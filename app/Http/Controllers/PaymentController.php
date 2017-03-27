<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Payment;
use App\UserTicket;
use Carbon\Carbon;
use Validator;
use App\AuthorizeNet;
use App\User;

class PaymentController extends Controller
{
    protected $payment;

    public function __construct(Payment $payment, AuthorizeNet $authorize) {
        $this->payment = $payment;
        $this->authorize = $authorize;
    }

    /**
     * GetPaymentAPI
     * @param $token
     * @desc | To get payment info
     */
    protected function getShow($token)
    {
        $columns = ['payments.id', 'payments.ticket_id',
                    'payments.amount', 'payments.token',
                    'payments.adult_num', 'payments.child_num',
                    'payments.payment_date', 'payments.transaction_response_code',
                    'payments.expired_date',
                    'tickets.name_'.\App::getLocale().' as name'];
        $payment = Payment::select($columns)
                          ->join('tickets', 'payments.ticket_id', '=', 'tickets.id')
                          ->where('payments.token', $token)
                          ->where('payments.valid',1)
                          ->firstOrFail();

        if($payment->expired_date < Carbon::now()){
            return response()->json(['message' => trans('custom.errors.expired')], 403);
        }else{
            return response()->json(['payment' => $payment], 200);
        }
    }

    /**
     * GetResultPaymentAPI
     * @param $token
     * @desc | To get payment info
     */
    protected function getResult($token)
    {
        $payment = Payment::select('payments.transaction_response_code')
                          ->join('users', 'payments.user_id', '=', 'users.id')
                          ->join('tickets', 'payments.ticket_id', '=', 'tickets.id')
                          ->where('payments.token', $token)
                          ->where('payments.valid',1)
                          ->firstOrFail();

        if($payment->transaction_response_code == config('define.authorize.response_code.approved')){
            return response()->json([
                'result' => 'success'
            ], 200);
        }else{
            return response()->json([
                'result' => 'failure'
            ], 200);
        }
    }

     /**
     * PaymentAPI
     * @param $token
     * @desc | To get payment info
     */
    protected function postCharge($token, Request $request)
    {
        $validator = Validator::make($request->all(),[
                'cardNumber' => 'required',
                'cardCode' => 'required',
                'cardExpirationDate' => 'required',
                'cardName' => 'required',
                ]);

        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.fail_to',['name'=>'payment']),
                'errors' => $validator->errors()
            ], 422);
        }

        \DB::beginTransaction();

        $payment    = Payment::where('token', $token)
                          ->firstOrFail();
        $ticket     = \App\Ticket::where('id', $payment->ticket_id)->first();
        $user       = User::find($payment->user_id);
        $errors     = [];
        $items      = array();

        /*** for line items in AN 10062016 ***/
        $classifications = ['adult','child'];
        foreach ($classifications as $key => $class) {
            $num = $class.'_num';
            $price = $class.'_price';

            if (is_null($payment->$price) || $payment->$num == 0) {
                continue;
            }
            $items[$key]['qty'] = $payment->$num;
            $items[$key]['price'] = $payment->$price;
            $items[$key]['id'] = $payment->ticket_id;
            $items[$key]['name'] = $ticket->name_en."(".$class.")";
            $items[$key]['description'] = $ticket->description_en;
        } // **


        if($payment->expired_date < Carbon::now() ||
           !empty($payment->transaction_response_code)) {
            \DB::rollBack();
            return response()->json(['message' => trans('custom.errors.expired')], 403);
        }

        // AuthorizeNet Save or Edit Profile
        if($user->customer_profile_id == NULL) {
            $profile = $this->authorize->saveProfileTo(
                $request->input('cardNumber'),
                $request->input('cardExpirationDate'),
                $request->input('cardCode'),
                $payment->user_id,
                $user->email
            );
        } else {
            $profile = $this->authorize->getCustomerProfile(
                $request->input('cardNumber'),
                $request->input('cardExpirationDate'),
                $request->input('cardCode'),
                $payment->user_id,
                $user->email,
                $user->customer_profile_id
            );
        } //**

        if( $profile->isError() != config('define.valid.false') ) {
            $errors = $profile->getErrors();
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.fail_to',['name'=>'payment']),
                'errors' => $errors
            ], 422);
        } else {
            $payment->customer_payment_profile_id = $profile->customer_payment_profile_id;
            $user->customer_profile_id = $profile->customer_profile_id;
            if(!$payment->save() || !$user->save()) {
                \DB::rollBack();
                return response()->json([
                    'message' => trans('custom.errors.occurred')
                ], 400);
            }else{
                \DB::commit();
            }
        }

        \DB::beginTransaction();
        // charge
        $response = $this->authorize->charge(
            $profile->customer_profile_id,
            $profile->customer_payment_profile_id,
            $payment->amount,
            $payment->id,
            $items
        );
        if ($response->isError() != config('define.valid.false')){
            return response()->json([
                'message' => trans('custom.errors.occurred'),
                'errors' => $response->getErrors()
            ], 422);
        }

        $payment->api_response = json_encode((array)$response);
        $payment->transaction_id = $response->transactionResponse->transactionId;
        $payment->transaction_response_code = $response->transactionResponse->responseCode;
        $payment->payment_date = Carbon::now();
        $user_ticket = \App\UserTicket::create([
            'user_id'       => $payment->user_id,
            'ticket_id'     => $payment->ticket_id,
            'adult_num'     => $payment->adult_num,
            'child_num'     => $payment->child_num,
            'purchase_date' => \Carbon\Carbon::now(),
            'valid'         => true
        ]);
        $payment->user_ticket_id = $user_ticket->id;

        if(!$payment->save() || !$user_ticket->save() || !$user->save()) {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occurred')
            ], 400);
        }else{
            \DB::commit();
            return response()->json([
                'result' => 'success'
            ], 200);
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Support\JsonableInterface;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\UserTicket;
use App\User;
use App\Payment;
use App\AuthorizeNet;

class UsersController extends Controller
{
    /** 
     * @var User
     */
    protected $user;
    
    /**
     * @param User $user
     */
    public function __construct(User $user,AuthorizeNet $authorize)
    {
        $this->user = $user;
        $this->authorize = $authorize;
    }

    /**
     * @type GET
     * @param $request,$id
     * @desc Get User Infomation By User Id
     */
    protected function GetUserInformation(Request $request, $id)
    {
        $user = $this->user->getUserDetail($id);
    
        if(empty($user))
            return response()->json([], 204);
    
        return response()->json([
            'user' => !empty($user) ? $user : []
        ], 200);
    }
    
    /**
     * Validate inputed Fields
     * @param $request,$id
     * @desc Validate User input By User Id
     */
    protected function ValidateEditUser(Request $request,$id)
    {
        $validator = $this->ValidateFields($request, "1", $id);
    
        if ($validator->fails()){
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->messages()
            ], 422);
        }else{
            return response()->json([
                'result' => config('define.result.success')
            ], 200);
        }
    }
    
    /**
     * Edit User Information
     * @param $request,$id
     * @desc Update User input By User Id
     */
    protected function EditUserInformation(Request $request,$id)
    {
        $validator = $this->ValidateFields($request, "1", $id);

        if ($validator->fails())
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->messages()
            ], 422);

        $fields = [];
        $update_user = $this->user->findOrFail($id);

        \DB::beginTransaction();
        $update_user->name = $request->input('name');
        $update_user->email = $request->input('email');
        if(trim($request->input('password')) <> '') {
            $update_user->password = bcrypt($request->input('password'));
        }
        $update_user->email_magazine_subscribed = $request->input('email_magazine_subscribed');

        if($update_user->save()){
            \DB::commit();
            $user = $this->user->getUserDetail($id,$this->user->getFillable());
            return response()->json([
                'result' => config('define.result.success')
            ], 200);
        }else{
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occurred')
            ], 400);
        }
    }
    
    /**
     * @type PUT, GET
     * @param $request,$id
     * @desc Update User input By User Id, Retreive User Information By User Id
     */
    public function UserInformation(Request $request,$id)
    {
        $_edittype = $request->input('_edittype');
         
        if ($request->isMethod('put') && strtolower($_edittype) == strtolower('Validate')){
            return $this->ValidateEditUser($request,$id);
        }elseif($request->isMethod('put') && strtolower($_edittype) == strtolower('Save')){
            return $this->EditUserInformation($request,$id);
        }else{
            return $this->GetUserInformation($request,$id);
        }
    }
    
    /**
     * Validate inputed Fields
     * @param $request
     * @desc Create New User
     */
    protected function ValidateRegistUser(Request $request)
    {
        $validator = $this->ValidateFields($request, "0");
    
        if ($validator->fails()){
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->messages()
            ], 422 );
        }else{
            return response()->json([
                'result' => config('define.result.success')
            ] , 200 );
        }
    }
    
    /**
     * Register a User
     * @param $request
     * @desc Create New User
     */
    protected function RegistUser(Request $request)
    {
        $validator = $this->ValidateFields($request, "0");

        if ($validator->fails()){
            return response()->json([
                'message' => trans('custom.errors.conflict')
            ], 409);
        }
         
        foreach($request->input() AS $k => $v){
            if(in_array($k,$this->user->getFillable())){
                $this->user->{$k} = $v;
            }
        }
        $password = str_random(10);
        $this->user->password = bcrypt($password);

        //create free ticket
        \DB::beginTransaction();
        $issued_ticket = \App\IssuedTicket::create([
            'type'              => 'registration',
            'receive_key'       => str_random(25),
            'ticket_id'         => config('define.user_registration.ticket_id'),
            'adult_num'         => config('define.user_registration.adult_num'),
            'child_num'         => config('define.user_registration.child_num'),
            'issued_date'       => \Carbon\Carbon::now()
        ]);

        if($this->user->save() || $issued_ticket){
            \DB::commit();
            $user = $this->user;
            \Mail::send('email.auth.registration',
                [
                    'title'         => trans('thanks_registration.subject'),
                    'username'      => $this->user->name,
                    'password'      => $password,
                    'web_link'      => env('WEB_URL').'/auth/login',
                    'app_link'      => env('WEB_URL').'/openapp',
                    'receive_key'   => $issued_ticket->receive_key
                ],
                function ($m) use ($user) {
                    $m->from(env('MAIL_ADDRESS'));
                    $m->to($user->email, $user->name)->subject(trans('thanks_registration.subject'));
                }
            );

            return response()->json([
                'result' => config('define.result.success')
            ], 200);
        } else {
            \DB::rollBack();
        }
         
        return response()->json([
            'message' => trans('custom.errors.occurred')
        ], 400);
    
    }
    
    /**
     * @type POST
     * @param $request,$id
     * @desc Update User input By User Id, Retreive User Information By User Id
     */
    public function UserRegistration(Request $request)
    {
        $_regtype = $request->input('_regtype');
         
        if ($request->isMethod('post') &&
            strtolower($_regtype) == strtolower('Validate')){

            return $this->ValidateRegistUser($request);

        } elseif ($request->isMethod('post') &&
            strtolower($_regtype) == strtolower('Save')){

            return $this->RegistUser($request);

        } else {

            return response()->json([
                'message' => trans('custom.errors.occurred') 
            ], 400);

        }
    }
    
    /**
     * Validate Fields
     * @param $request
     * @desc Return Non-Error Messages
     */
    protected function ValidateFields($request, $type, $id = 0)
    {
    
        $validation['name'] = 'required|max:255';
        $validation['email'] = 'required|email|max:255|unique:users';
        $validation['email_confirm'] = 'required|same:email';

        if($type == 1){
    
            $validation['email'] .= ',email,'.$id;

            if (empty($request->input('password')) &&
                empty($request->input('password_confirm'))){

                $validation['password'] = '';
                $validation['password_confirm'] = '';
    
            }else{

                $validation['password'] = 'min:5|max:60|required';
                $validation['password_confirm'] = 'required|same:password';

            }
        }else{

            $validation['service_term'] = 'required';

        }
    
        return Validator::make($request->all(), $validation);
    
    }

    /**
     * Get Users Ticket Functions
     * @param $request
     * @by Rei
     */
    public function getTickets(Request $request,$id)
    {
        $data = \App\UserTicket::select()
            ->where('user_id',$id)
            ->with('ticket')
            ->orderBy('id', 'desc');
        if($request->has('cancelable')) {
            $allowed_settled_date = \Carbon\Carbon::now()->subDays(120);
            //check user purchases
            $purchase_arr = [];
            $purchases = Payment::where('user_id',$id)->where('payment_date','>=',$allowed_settled_date)->distinct('user_ticket_id')->get(['user_ticket_id']);
            foreach($purchases as $purchase) {
                $purchase_arr[] = $purchase->user_ticket_id;
            }//** 
            
            //check for splits
            $split_arr = [];
            $splits = \App\SplitHistory::whereIn('user_ticket_id', $purchase_arr)->distinct('user_ticket_id')->get(['user_ticket_id']);
            foreach($splits as $split) {
                $split_arr[] = $split->user_ticket_id;
            } //**
            $data->whereNull('started_date');
            $data->whereIn('id', array_diff($purchase_arr,$split_arr));
        }
        
        $user_tickets = $data->get();
        foreach($user_tickets as $key => $user_ticket){
            $splits = \App\SplitHistory::where('user_ticket_id', $user_ticket->id)
                ->with('issued_ticket')->get();
            $user_tickets[$key]->split_tickets = $splits;
            $user_tickets[$key] = $this->makeUserTicketDetail($user_tickets[$key]);
        }
        return response()->json([
            'user_tickets' => $user_tickets
        ], 200);
    }

    public function getTicketsShow($id,$user_ticket_id)
    {
        $data   = \App\UserTicket::where('user_id',$id)
            ->where('id',$user_ticket_id)
            ->with('ticket')
            ->get();
        $splits = \App\SplitHistory::where('user_ticket_id', $user_ticket_id)->with('issued_ticket')->get();

        $data->first()['split_tickets'] = $splits;
        
        if($data->count()) {
            return response()->json([
                'user_ticket' => $this->makeUserTicketDetail($data->first())
            ], 200);
        } else {
            return response()->json('',204);
        }
    }

    protected function makeUserTicketDetail($value)
    {
        if(isset($value->split_tickets)){
            foreach($value->split_tickets as $key => $split_ticket){
                $value->split_tickets[$key]->receive_key = $split_ticket->issued_ticket->receive_key;
                unset($value->split_tickets[$key]->issued_ticket);
            }
        }
        $temp = array(
            'id'            => $value->id,
            'name'          => $value->ticket->{"name_".\App::getLocale()},
            'image_url'     => $value->ticket->image_url,
            'description'   => $value->ticket->{"description_".\App::getLocale()},
            'type'          => $value->ticket->type,
            'adult_price'   => $value->ticket->adult_price,
            'child_price'   => $value->ticket->child_price,
            'adult_num'     => $value->adult_num,
            'child_num'     => $value->child_num,
            'color'         => $value->ticket->color,
            'purchase_date' => $value->purchase_date,
            'received_date' => $value->received_date,
            'started_date'  => $value->started_date,
            'expired_date'  => $value->expired_date,
            'split_tickets' => isset($value->split_tickets)?$value->split_tickets:null
        );
        return $temp;
    }

    public function postTicketsSplit(Request $request,$id,$user_ticket_id)
    {
        $user_ticket = \App\UserTicket::where('id',$user_ticket_id)
            ->where('user_id', $id)
            ->where('valid', true)
            ->firstOrFail();

        $request->request->add(['total_num' => $request->adult_num + $request->child_num]);
        $validator = \Validator::make($request->all(), [
            'adult_num' => 'required|numeric|max:'.$user_ticket->adult_num,
            'child_num' => 'required|numeric|max:'.$user_ticket->child_num,
            'total_num' => 'numeric|min:1'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message'  => trans('custom.errors.validation'),
                'errors' => $validator->errors()
            ], 422);
        }

        if (!is_null($user_ticket->expired_date) &&
            strtotime($user_ticket->expired_date) < time()){
            return response()->json([
                'message' => trans('custom.errors.ticket_already_expired')
            ], 400);
        }

        \DB::beginTransaction();

        $user_ticket->adult_num = $user_ticket->adult_num - $request->input('adult_num');
        $user_ticket->child_num = $user_ticket->child_num - $request->input('child_num');

        $issued_ticket         = \App\IssuedTicket::create([  //issued ticket
            'type'              => 'split',
            'receive_key'       => str_random(25),
            'ticket_id'         => $user_ticket->ticket_id,
            'adult_num'         => $request->input('adult_num'),
            'child_num'         => $request->input('child_num'),
            'started_date'      => $user_ticket->started_date,
            'expired_date'      => $user_ticket->expired_date,
            'purchase_date'     => $user_ticket->purchase_date,
            'issued_date'       => \Carbon\Carbon::now()
        ]);

        $split_ticket_history = \App\SplitHistory::create([ // split ticket history
            'user_ticket_id'        => $user_ticket->id,
            'issued_ticket_id'      => $issued_ticket->id,
            'splitted_date'         => \Carbon\Carbon::now(),
            'adult_num'             => $request->input('adult_num'),
            'child_num'             => $request->input('child_num')
        ]);

        if(!$user_ticket->save() || !$issued_ticket || !$split_ticket_history) {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.db') 
            ], 400);
        } else {
            \DB::commit();
            return response()->json([
                'split_ticket' => array(
                    'id'            => $issued_ticket->id,
                    'receive_key'   => $issued_ticket->receive_key,
                    'adult_num'     => $issued_ticket->adult_num,
                    'child_num'     => $issued_ticket->child_num,
                    'splitted_date' => \Carbon\Carbon::now()
                )
            ], 200);
        }
    }

    public function postTicketsReceive(Request $request,$id)
    {
        $_regtype = $request->input('_registtype');
         
        if (strtolower($_regtype) == strtolower('Validate')){
            return $this->validateTicketsReceive($request, $id);
        } elseif (strtolower($_regtype) == strtolower('Regist')){
            return $this->registTicketsReceive($request, $id);
        } else {
            return response()->json([
                'message' => trans('custom.errors.occurred')
            ], 400);
        }
    }

    /**
     * Validate inputed Fields
     * @param $request
     * @desc Create New User
     */
    protected function validateTicketsReceive(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'receive_key' => 'required|exists:issued_tickets,receive_key,valid,1,user_ticket_id,NULL',
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ], 422);
        }

        $receive_key = $request->input('receive_key');
        $issued_ticket = \App\IssuedTicket::selectByReceiveKey($receive_key)->firstOrFail();
     
        if (!is_null($issued_ticket->expired_date) &&
            strtotime($issued_ticket->expired_date) < time()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => ['split_ticket' => [trans('custom.errors.ticket_already_expired')]]
            ], 422);
        }

        return response()->json([
            'receive_ticket' => $issued_ticket
        ], 200 );
    }
 

    public function registTicketsReceive(Request $request,$id)
    {
        $validator = \Validator::make($request->all(), [
            'receive_key' => 'required|exists:issued_tickets,receive_key,valid,1,user_ticket_id,NULL',
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ], 422);
        }

        $receive_key = $request->input('receive_key');
        
        $issued_ticket =  \App\IssuedTicket::select()
            ->where('receive_key', $receive_key)
            ->first();

        if (!is_null($issued_ticket->expired_date) &&
            strtotime($issued_ticket->expired_date) < time()) {
            return response()->json([
                'message' => trans('custom.errors.ticket_already_expired')
            ], 400);
        }

        \DB::beginTransaction();
        $user_ticket         = \App\UserTicket::create([
            'user_id'           => $id,
            'ticket_id'         => $issued_ticket->ticket_id,
            'adult_num'         => $issued_ticket->adult_num,
            'child_num'         => $issued_ticket->child_num,
            'started_date'      => $issued_ticket->started_date,
            'expired_date'      => $issued_ticket->expired_date,
            'purchase_date'     => $issued_ticket->purchase_date,
            'received_date'     => \Carbon\Carbon::now(),
        ]);

        $issued_ticket->user_ticket_id = $user_ticket->id;

        if(!$issued_ticket->save() || !$user_ticket) {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.db')
            ], 400);
        } else {
            \DB::commit();
            return response()->json([
                'result'  => config('define.result.success')
            ], 200);
        }
    }

    public function postStartTicket(Request $request, $id, $user_ticket_id)
    {
        $user_ticket = \App\UserTicket::where('id',$user_ticket_id)
            ->where('user_id', $id)
            ->where('valid', true)
            ->firstOrFail();

        $issued_ticket = \App\IssuedTicket::where('user_ticket_id',$user_ticket_id)
            ->where('valid', true)
            ->first();

        if (!is_null($user_ticket->started_date) ||
            ($user_ticket->adult_num == 0 && $user_ticket->child_num == 0)) {
            return response()->json([
                'message' => trans('custom.errors.ticket_already_used')
            ], 400);
        }

        if(count($issued_ticket) > 0) {
            $issued_ticket->started_date = \Carbon\Carbon::now()->toDateTimeString();
            if($user_ticket->ticket->type == config("define.ticket_type.day")){
                $issued_ticket->expired_date = 
                    \Carbon\Carbon::now()->addDays(
                        $user_ticket->ticket->duration
                    )->toDateTimeString();
            }elseif($user_ticket->ticket->type == config("define.ticket_type.time")){
                $issued_ticket->expired_date =
                    \Carbon\Carbon::now()->addHours(
                        $user_ticket->ticket->duration
                    )->toDateTimeString();
            }
            $issued_ticket->save();
        }

        $user_ticket->started_date  = \Carbon\Carbon::now()->toDateTimeString();

        if($user_ticket->ticket->type == config("define.ticket_type.day")){
            $user_ticket->expired_date = 
                \Carbon\Carbon::now()->addDays(
                    $user_ticket->ticket->duration
                )->toDateTimeString();
        }elseif($user_ticket->ticket->type == config("define.ticket_type.time")){
            $user_ticket->expired_date =
                \Carbon\Carbon::now()->addHours(
                    $user_ticket->ticket->duration
                )->toDateTimeString();
        }else{
            return response()->json([
                'message' => trans('custom.errors.occurred')
            ], 400);
        }
        $user_ticket->save();

        $splits = \App\SplitHistory::where('user_ticket_id', $user_ticket_id)->with('issued_ticket')->get();
        $user_ticket->split_tickets = $splits;

        return response()->json([
            'user_ticket' => $this->makeUserTicketDetail($user_ticket),
        ], 200);

    }

    /**
     * PostPaymentTokenAPI
     * @param $user_id $order_id
     * @desc | To get token of an order in a user
     */
    protected function postPaymentToken(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ticket_id' => 'required',
                'adult_num' => 'required',
                'child_num' => 'required'
            ]
        );
    
        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ],422);
        }

        $payment = Payment::createCharge(
            $id, 
            $request->input('ticket_id'),
            $request->input('adult_num'),
            $request->input('child_num')
        );

        if(!$payment->save()){
            return response()->json([
                'message' => trans('custom.errors.occured')
            ], 400);
        }else{
            return response()->json([
                'token' => $payment->token
            ], 200);
        }
    }

    protected function postCancelTicket(Request $request, $id, $user_ticket_id) {
        $user_ticket   = \App\UserTicket::where('user_id',$id)
            ->where('id',$user_ticket_id)
            ->whereNull('started_date')
            ->first();

        //check if used
        if(count($user_ticket) == 0) {
            return response()->json([
                'message' => config('define.result.failure'),
                'errors'  => array('reason' => [trans('custom.cancel_ticket_used')])
            ], 412);
        } else {
            if($user_ticket->first()->valid != 1) {
                return response()->json([
                    'message' => trans('custom.cancel_ticket_cancelled')
                ], 412);
            }
        } 

        //check if split
        $if_split = \App\SplitHistory::where('user_ticket_id', $user_ticket_id)->get();
        if($if_split->count() > 0) {
            return response()->json([
                'message'  => config('define.result.failure'),
                'errors'  => array('reason' => [trans('custom.cancel_ticket_splitted')])
            ], 412);
        }
        
        $validator = Validator::make(
            $request->all(),[
                'reason'    => 'required|max:1000'
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ],422);
        }

        if(strtolower($request->input('_contype')) == strtolower('Validate')) {
            return response()->json([
                'result'  => config('define.result.success')
           ], 200);
        }
       
        \DB::beginTransaction();

        $user = User::find($user_ticket->user_id);
        $payment = Payment::where('user_ticket_id',$user_ticket_id)
        ->first([
            'amount',
            'transaction_id',
            'customer_payment_profile_id',
            'adult_price',
            'child_price',
            'ticket_id',
            'adult_num',
            'child_num'
        ]);
        $ticket     = \App\Ticket::where('id', $payment->ticket_id)->first();
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

        // getProfile
        $an_getProfile = $this->authorize->getProfile(
            ($user->customer_profile_id != NULL)?$user->customer_profile_id:0,
            ($payment->customer_payment_profile_id != NULL)?$payment->customer_payment_profile_id:0
        );
        if ($an_getProfile->isError()){
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.cancel_ticket_no_possible'),
                'errors'  => $an_getProfile->getErrors()
            ], 412);
        }

        // refund
        $payment_new = Payment::createRefund(
            $id,
            $user_ticket->ticket_id,
            $user_ticket_id,
            $user_ticket->adult_num,
            $user_ticket->child_num,
            $payment->adult_price,
            $payment->child_price,
            $payment->amount
        );
        $response = $this->authorize->refund(
            $an_getProfile->cardNum,
            $payment->amount,
            $payment->transaction_id,
            $payment_new->id,
            $items
        );
        if ($response->isError()){
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occurred'),
                'errors' => $response->getErrors()
            ], 412);
        }
        // ** end refund

        $tresponse = $response->transactionResponse;

        $user_ticket->valid = 0;
        $payment_new->payment_date                  = \Carbon\Carbon::now();
        $payment_new->transaction_id                = $tresponse->transactionId;
        $payment_new->transaction_response_code     = $tresponse->responseCode;
        $payment_new->api_response                  = json_encode((array)$response);
        $payment_new->customer_payment_profile_id   = $payment->customer_payment_profile_id;

        if($user_ticket->save() && $payment_new->save()) {
            \DB::commit();
            //EMAIL
            $reason = $request->input('reason');
            \Mail::send('email.ticket.cancel',[
                'title' => trans('custom.cancel_email.subject'),
                'user' => $user,
                'reason' => $reason
            ],function ($m) use ($user,$reason) {
                $m->from(env('MAIL_ADDRESS'));
                $m->to($user->email, $user->name)->subject(trans('custom.cancel_email.subject'));
            });
            \Mail::send('email.ticket.admin-cancel',[
                'title' => trans('custom.cancel_email.subject'),
                'user' => $user,
                'reason' => $reason
            ],function ($m) use ($user,$reason) {
                $m->from(env('MAIL_ADDRESS'));
                $m->to(env('MAIL_ADDRESS'))->subject(trans('custom.cancel_email.subject'));
            });
            return response()->json([
                'result'  => config('define.result.success')
            ], 200);
        } else {
            \DB::rollBack();
            return response()->json([
                'message' => trans('custom.errors.occured')
            ], 400);
        }
    }

    protected function getUsers(Request $request) {
        $users = $this->user->getUsersforAdmin($request);
        $pagination = clone($users);
        $pagination = $pagination->toArray();
        unset($pagination['data']);
        $users = $users ->getCollection()->all();

        return response()->json([
            'users' => $users,
            'pagination' => $pagination
        ], 200);
    }

}

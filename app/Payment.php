<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use App\Ticket;

class Payment extends Model
{
    protected $table = 'payments';
    
    protected $fillable = ['id','type','token','user_id','ticket_id','user_ticket_id','adult_num','child_num','adult_price','child_price','amount'];

    static function createCharge($user_id, $ticket_id, $adult_num, $child_num) {

        $ticket = Ticket::findOrFail($ticket_id);
        $amount = $ticket->adult_price * $adult_num +
                  $ticket->child_price * $child_num; 

        $payment = self::Create(
            [
                'user_id'   => $user_id,
                'ticket_id' => $ticket_id,
                'adult_num' => $adult_num,
                'child_num' => $child_num,
                'adult_price' => $ticket->adult_price,
                'child_price' => $ticket->child_price,
                'amount'    => $amount
            ]
        );

        $exdate = Carbon::parse(date("Y-m-d H:i:s"));
        foreach(config('define.token_time.payment') as $k => $v){
            if($v == 0)continue;
            $exdate->{"add".ucfirst($k)}($v);
        }
        $payment->token = str_random(75);
        $payment->expired_date = $exdate->format('Y-m-d H:i:s');
        $payment->amount = $amount;

        return $payment;

    }

    static function createRefund($user_id,$ticket_id,$user_ticket_id,$adult_num,$child_num,$adult_price,$child_price,$amount) {
        $payment = self::firstOrCreate([
            'type'              => 'refund',
            'user_id'           => $user_id,
            'ticket_id'         => $ticket_id,
            'user_ticket_id'    => $user_ticket_id,
            'adult_num'         => $adult_num,
            'child_num'         => $child_num,
            'adult_price'       => $adult_price,
            'child_price'       => $child_price,
            'amount'            => $amount
            ]);

        return $payment;
    }

    static function getSalesSummary($request) {
        $sales = parent::leftJoin('tickets', 'tickets.id', '=', 'payments.ticket_id')
            ->where('payments.valid',1)
            ->whereNotNull('transaction_id')
            ->where('transaction_response_code', 1);

        if(!$request->has('from_date') && $request->has('to_date')) {
            $beginning_date = \DB::table('payments')->min('payment_date');
            $sales->whereBetween('payment_date', array($beginning_date,$request->input('to_date')));
        }
        else if($request->has('from_date') && !$request->has('to_date')) {
            $latest_date = \DB::table('payments')->max('payment_date');
            $sales->whereBetween('payment_date', array($request->input('from_date'),$latest_date));
        }
        else if($request->has('from_date') && $request->has('to_date')) {
            $sales->whereBetween('payment_date', array($request->input('from_date'),$request->input('to_date')));
        }

        if($request->has('ticket_id')) {
            $sales->where('ticket_id', $request->input('ticket_id'));
        }

        return $sales->get([
            'payments.id',
            'tickets.name_'.\App::getLocale().' as name',
            'payments.type',
            'ticket_id',
            'adult_num',
            'child_num',
            'payments.adult_price',
            'payments.child_price',
            'amount',
            'payment_date',
            'transaction_id',
            'transaction_response_code',
            'payments.valid'
        ]);
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket','ticket_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssuedTicket extends Model
{
    protected $table = 'issued_tickets';

    protected $fillable 	= ['type','receive_key','ticket_id','adult_num','child_num','started_date','expired_date','purchase_date','issued_date','user_ticket_id','valid'];

    public function split_history() {
        return $this->hasOne('App\SplitHistory');
    }

    static function getIssuedTickets($request) {
        $offset = 15;
        if($request->has('offset')) {
            $offset = $request->input('offset');
        }

        $q = parent::leftJoin('tickets', 'tickets.id', '=', 'issued_tickets.ticket_id')
            ->leftJoin('user_tickets', 'user_tickets.id','=','issued_tickets.user_ticket_id')
            ->leftJoin('users','users.id','=','user_tickets.user_id')
            ->where('issued_tickets.ticket_id', $request->input('ticket_id'))
            ->where('issued_tickets.type', $request->input('issued_ticket_type'))
            ->where('issued_tickets.valid',1)
            ->where('tickets.valid',1);

        $check_dates = self::FromToDate($q,'issued_tickets','issued_date',$request);
        $issued = $check_dates->select([
                'issued_tickets.id', 'receive_key', 'issued_tickets.adult_num','issued_tickets.child_num','issued_date','tickets.name_'.\App::getLocale().' as name',
                'tickets.description_'.\App::getLocale().' as description','tickets.image_url','issued_tickets.user_ticket_id','users.name as username'
            ]);
        return $issued->paginate($offset);
    }

    static function selectByReceiveKey($receive_key)
    {
        $filter = [
            'issued_tickets.id',
            'issued_tickets.receive_key',
            'issued_tickets.adult_num',
            'issued_tickets.child_num',
            'issued_tickets.expired_date',
            'issued_tickets.purchase_date',
            'issued_tickets.user_ticket_id',
            'tickets.name_'.\App::getLocale().' as name',
            'tickets.description_'.\App::getLocale().' as description',
            'tickets.image_url',
        ];
        $query = parent::__callStatic("select", $filter)
            ->join('tickets', 'issued_tickets.ticket_id', '=', 'tickets.id')
            ->where('issued_tickets.receive_key', $receive_key)
            ->where('issued_tickets.valid',1)
            ->where('tickets.valid',1)
            ->withoutGlobalScope(ValidScope::class);

        return $query;
    }

    static function getCounters($request) {
        $count = array();
        $total = 0;
        $receive = 0;
        $not_receive = 0;

        $q = parent::where('ticket_id', $request->input('ticket_id'))
            ->where('type', $request->input('issued_ticket_type'))
            ->where('valid',1);

        $check_dates = self::FromToDate($q,'issued_tickets','issued_date',$request);
        $issued_tickets = $check_dates->get(['user_ticket_id']);

        foreach ($issued_tickets as $key => $issued_ticket) {
            $total+=1;
            if(is_null($issued_ticket->user_ticket_id)) {
                $not_receive+=1;
            } else {
                $receive+=1;
            }
        }

        $count['issued'] = $total;
        $count['receive'] = $receive;
        $count['not_receive'] = $not_receive;

        return $count;
    }

    private static function FromToDate($q,$table,$column,$request) {
        if(!$request->has('from_date') && $request->has('to_date')) {
            $beginning_date = \DB::table($table)->min($column);
            $q->whereBetween($column, array($beginning_date,$request->input('to_date')));
        }
        else if($request->has('from_date') && !$request->has('to_date')) {
            $latest_date = \DB::table($table)->max($column);
            $q->whereBetween($column, array($request->input('from_date'),$latest_date));
        }
        else if($request->has('from_date') && $request->has('to_date')) {
            $q->whereBetween($column, array($request->input('from_date'),$request->input('to_date')));
        }

        return $q;
    }
    
}

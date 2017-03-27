<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ValidScope;

class Ticket extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ValidScope);
    }

    function getColumns(){
        return [
            'id',
            'name_'.\App::getLocale().' as name',
            'description_'.\App::getLocale().' as description',
            'image_url',
            'adult_price',
            'child_price',
            'type',
            'duration',
            'recommended'
        ];
    }

    function getTickets($filter = array())
    {
        $tickets = $this->select($this->getColumns())
                        ->where('valid', '=', true);
        foreach($filter as $key => $val){
            if($key == "purchasable"){
                if($val == "1"){
                    $tickets->where(function ($query) {
                        $query->whereNotNull('adult_price')
                              ->orWhereNotNull('child_price');
                              
                    });
                }
            }else{
                $tickets->where($key, $val);
            }
        }
        $tickets = $tickets->get();

        return $tickets;
    }

    function getTicket($id)
    {
        $ticket = $this->select($this->getColumns())
                       ->where('id', $id)
                       ->where('valid', '=', true)
                       ->first();

        return $ticket;
    }

    function getAdminTickets($request) {
        $offset = 15;
        if($request->has('offset')) {
            $offset = $request->input('offset');
        }
        
        $tickets = $this->select($this->getColumns())->where('valid', true);

        if($request->has('status')) {
            $status = $request->input('status');
            switch ($status) {
                case 'no-purchase':
                    $tickets->where(function ($query) {
                        $query->whereNull('adult_price')
                              ->whereNull('child_price');
                    });
                    break;
                case 'recommend':
                    $tickets->where('recommended', 1);
                    break;
                case 'purchase':
                    $tickets->where(function ($query) {
                        $query->whereNotNull('adult_price')
                              ->orWhereNotNull('child_price');
                    });
                    break;

                default:
                    break;
            }
        }

        if($request->has('search')) {
            $like = $request->input('search');
            $tickets->where('name_'.\App::getLocale(), 'LIKE', "%$like%")
                ->orWhere('description_'.\App::getLocale(), 'LIKE', "%$like%");
        }
        return $tickets->paginate($offset);
    }


    function user_ticket() {
        return $this->hasOne('App\UserTicket');
    }
    function payment() {
        return $this->hasOne('App\Payment');
    }
    
}

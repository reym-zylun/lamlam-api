<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ValidScope;

class UserTicket extends Model
{
    protected $table = 'user_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'ticket_id', 'adult_num', 'child_num', 'purchase_date','valid','started_date','expired_date','receive_key','parent_id','splitted_date','received_date','started_date','expired_date'
    ];

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

    public function ticket()
    {
        return $this->belongsTo('App\Ticket','ticket_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

}

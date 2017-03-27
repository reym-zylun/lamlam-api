<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ValidScope;

class PurchaseHistory extends Model
{
    protected $table = 'purchase_histories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id', 'user_ticket_id', 'adult_num', 'child_num',
        'amount', 'purchase_date', 'valid'
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

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SplitHistory extends Model
{
    protected $table 		= 'split_histories';

    protected $fillable 	= ['user_ticket_id','issued_ticket_id','splitted_date','adult_num','child_num','valid'];

    public function issued_ticket() {
    	return $this->belongsTo('\App\IssuedTicket', 'issued_ticket_id')->select(['id','receive_key']);
    }
}

<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\ValidScope;

class AccessToken extends Authenticatable
{

    protected $table = 'access_tokens';
    protected $fillable = [
        'api_token',
        'expired_date',
        'refresh_token',
        'refresh_token_expired_date',
        'user_id',
        'api_client_id',
        'valid',
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

    public function user_data() {
        return $this->belongsTo('App\User','user_id');
    }
}

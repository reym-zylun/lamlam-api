<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ValidScope;

class ApiClient extends Model
{
    protected $table = 'api_clients';
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

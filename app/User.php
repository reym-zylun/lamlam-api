<?php

namespace App;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\ValidScope;
use Carbon\Carbon;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','email_magazine_subscribed','customer_profile_id', 'customer_payment_profile_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

    /** 
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function getAllUsers()
    {
        $users = array();
   
        $usrs = DB::select('select * from users');
             
        foreach($usrs AS $k => $v)
            $users[$v->id] = $v;
         
        return $users;
    }
    
    /**
     * Show a User Detail.
     *
     * @return Response
     */
    public function getUserDetail($id)
    {
        $user = DB::select('select * from users where id = ?', [$id]);
        
        return (isset($user[0]) ? $user[0] : null);  
    } 
       
    public function access_token() {
        return $this->hasOne('App\AccessToken');
    }

    public function user_ticket() {
        return $this->hasOne('App\UserTicket');
    }
    
    /**
     * Generating of tokens.
     *
     * @return Response
     */
    public function generateToken() {

        $exdate = Carbon::parse(date("Y-m-d H:i:s"));
        foreach(config('define.token_time.access') as $k => $v){
            if($v == 0)continue;
            $exdate->{"add".ucfirst($k)}($v);
        }
        $rt_exdate = Carbon::parse(date("Y-m-d H:i:s"));
        foreach(config('define.token_time.refresh') as $k => $v){
            if($v == 0)continue;
            $rt_exdate->{"add".ucfirst($k)}($v);
        }
        
        return array(
            'api_token'                  => str_random(75),
            'expired_date'               => $exdate->format('Y-m-d H:i:s'),
            'refresh_token'              => str_random(75),
            'refresh_token_expired_date' => $rt_exdate->format('Y-m-d H:i:s')
        );
    }

    public function getUsersforAdmin($request) {
        $offset = 15;
        if($request->has('offset')) {
            $offset = $request->input('offset');
        }

        $users = $this->select(['id','name','email','email_magazine_subscribed'])->orderBy('id','asc');

        if($request->has('search')) {
            $like = $request->input('search');
            $users->where('name', 'LIKE', "%$like%")
            ->orWhere('email', 'LIKE', "%$like%");
        }

        return $users->paginate($offset);
    }

}


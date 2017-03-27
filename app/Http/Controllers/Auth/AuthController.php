<?php 
namespace App\Http\Controllers\Auth;
use App\User;
use App\AccessToken;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class AuthController extends Controller {

    protected $user; 
    protected $auth;

    public function __construct(Guard $auth, User $user)
    {
        $this->user         = $user; 
        $this->auth         = $auth;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function postRefresh(Request $request) {
        $access_token = $this->auth->user();
        $refresh_token_expire_date = $access_token->refresh_token_expired_date;
        if( strtotime($refresh_token_expire_date) < time() ) {
            return response()->json([
                'message'  => trans('custom.errors.token_expired')
            ], 401);
        } else {
            //update to db
            if($access_token->refresh_token == $request->input('refresh_token')) {
                $new_token = $this->user->generateToken();
                $access_token->api_token = $new_token['api_token'];
                $access_token->expired_date = $new_token['expired_date'];
                $access_token->save();
                return response()->json([ //response from db
                    'access_token' => $access_token->api_token,
                    'expired_date' => $access_token->expired_date,
                ], 200);
            }
            return response()->json([
                'message'  => trans('custom.errors.occurred')
            ], 400);
        }
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ], 422);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            $login_token = $this->saveTokens($user,$request->all()); //save to db
            if($login_token == false) {
                return response()->json([
                    'message'  => trans('custom.errors.occurred')
                ], 400);
            }
            return response()->json([// response from db
                'access_token'  => $login_token['api_token'],
                'expired_date'  => $login_token['expired_date'],
                'refresh_token' => $login_token['refresh_token'],
                'user'          => [
                    'id'   => $user->id,
                    'name' => $user->name,
                    'role' => $user->role
                ],
            ], 200);
        }else{
            return response()->json([
                'message' => trans('custom.errors.auth'),
                'errors'  => [
                    'auth' => [trans('auth.failed')]
                ]
            ], 422);
        }
    }
 
    protected function saveTokens($user, $data=null)
    {
        $api_client_id = \App\ApiClient::select('id')
            ->where('secret',$data['client_secret'])
            ->where('name',$data['client_name'])
            ->firstOrFail()
            ->id;

        \DB::beginTransaction();

        if(!env('MULTI_LOGIN', false)){
            try {
                AccessToken::where('user_id', $user->id)
                    ->where('valid', true) 
                    ->update(['valid' => false]);
            }catch(\Exception $e){
                \DB::rollBack();
                return false;
            }
        }

        $token = $user->generateToken();
        $new_access_token = AccessToken::create([
            'api_token'                   => $token['api_token'],
            'expired_date'                => $token['expired_date'],
            'refresh_token'               => $token['refresh_token'],
            'refresh_token_expired_date'  => $token['refresh_token_expired_date'],
            'user_id'                     => $user->id,
            'api_client_id'               => $api_client_id,
            'valid'                       => true
        ]);

        if(!$new_access_token) {
            \DB::rollBack();
            return false;
        } else {
            \DB::commit();
            return array(
                'api_token'         =>  $new_access_token->api_token,
                'expired_date'      =>  $new_access_token->expired_date,
                'refresh_token'     =>  $new_access_token->refresh_token
            );
        }
    }

    /*
    public function guardData($guard=null) {
        if($guard=="api") {
            return [
                'id'    => Auth::guard($guard)->user()->user_data->id,
                'name'  => Auth::guard($guard)->user()->user_data->name,
                'email' => Auth::guard($guard)->user()->user_data->email,
            ];
        } else if($guard=="web") {
            return [
                'id'    => Auth::guard($guard)->user()->id,
                'name'  => Auth::guard($guard)->user()->name,
                'email' => Auth::guard($guard)->user()->email,
            ];
        }
    }
     */

}

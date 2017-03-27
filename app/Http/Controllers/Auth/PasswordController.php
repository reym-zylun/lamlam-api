<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function postReissuePassword(Request $request) {
        $validator = \Validator::make($request->all(),[
            'email' => 'required|email|exists:users'
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.validation'),
                'errors'=>$validator->errors()
            ], 422);
        }

        $user = \App\User::where('email',$request->input('email'))->firstOrFail();
        $new_password   = str_random(10);
        $user->password = bcrypt($new_password);
        if($user->save()) {
            \Mail::send('email.auth.forgot', 
                [
                    'title'    => 'New Password Request',
                    'username' => $user->name,
                    'password' => $new_password,
                    'link' => env('WEB_URL').'/auth/login'
                ],
                function($message) use($user) {
                    $message->from(env('MAIL_USERNAME'), 'Account Recovery');
                    $message->to($user->email,$user->name)->subject('New Password Request');
                }
            );
            return response()->json([
                'result' => config('define.result.success')
            ], 200);
        } else {
            return response()->json([
                'message' => trans('custom.error.occurred'),
            ], 400);
        }
    }
}

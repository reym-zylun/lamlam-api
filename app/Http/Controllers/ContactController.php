<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /** 
     * @var Contact
     */
    protected $contact;

    /**
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @type POSS
     * @param $request,$id
     * @desc Update User input By User Id, Retreive User Information By User Id
     */
    public function postContact(Request $request)
    {
        $_registtype = $request->input('_registtype');
         
        if (strtolower($_registtype) == strtolower('Validate')){
            return $this->ContactValidate($request);
        }elseif(strtolower($_registtype) == strtolower('Regist')){
            return $this->ContactMessaging($request);
        }else{
            return response()->json([
                'message' => trans('custom.errors.occurred')
            ], 400);
        }
    }
 
    /**
     * @type POST
     * @param $request
     * @desc Validate Input
     */
    public function ContactValidate(Request $request)
    {
        $validator = $this->ValidateFields($request);
        
        if ($validator->fails()){
             
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors' => $validator->messages()
            ], 422);
         
        }else{
        
            return response()->json([
                'result'  => config('define.result.success')
            ], 200);

        }
    }
    
    /**
     * @type POST
     * @param $request
     * @desc Sending Message
     */
    public function ContactMessaging(Request $request)
    {
        $validator = $this->ValidateFields($request);
        if ($validator->fails()){
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors' => $validator->messages()
            ], 422);
        }
        
        $input = (object)$request->input();
        \Mail::send('email.contact.complete',
            [
                'title' => trans('custom.contact.complete'),
                'input' => $input,
            ],
            function ($m) use ($input) {
                $m->from(env('MAIL_ADDRESS'));
                $m->to($input->email, $input->name)->subject(trans('custom.contact.complete'));
            }
        );
        \Mail::send('email.contact.received',
            [
                'title' => trans('custom.contact.received'),
                'input' => $input,
            ],
            function ($m) use ($input) {
                $m->from(env('MAIL_ADDRESS'));
                $m->to(env('MAIL_ADDRESS'))->subject(trans('custom.contact.received'));
            }
        );

        return response()->json([
            'result'  => config('define.result.success')
        ], 200);
            
    }
    
    /**
     * Validate Fields
     * @param $request
     * @desc Return Non-Error Messages
     */
    protected function ValidateFields($request)
    {
    
       return Validator::make($request->all(), [
            'name'       => 'required|max:255',
            'email'      => 'required|email|max:255',
            'message'    => 'required|max:1000'
        ]);
    }
 
}

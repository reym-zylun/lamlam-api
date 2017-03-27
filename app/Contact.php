<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	
	 public function sendmail($data){

	 	try{
			
	 		if(isset($data['name'])){
	 			
		 		$subject = "A message from ".$data['name']."<".$data['email'].">";
	
			 	if(!empty($data['mail-subject']))
			 	
			 		$subject = $data['mail-subject'];
			 	
			 	$sent = \Mail::send(['html' => 'layouts.email.'.(empty(env('MAIL_CONTACT_THEME')) ? "basic" : env('MAIL_CONTACT_THEME')) ],
			 			
			 				['name' => $data['name'],
			 			
			 				'email' => $data['email'],
			 			
			 				'msg' => $data['message']], function ($message) use ($subject) {
			 					
			 					$message->from(env('MAIL_USERNAME'), 
			 							
			 								(!empty($data['mail-from']) ? $data['mail-from'] : 'Ram Ram - Contact Us'));
			 					
			 					if(!empty(env('MAIL_CONTACT_RECEIVER'))){
			 						
			 						foreach(explode(",", env('MAIL_CONTACT_RECEIVER')) AS $k => $v)
			 	
			 							$message->to($v);
			 	
			 						$message->subject($subject);
			 					}
			 			});
		 		
			 	if(count(\Mail::failures()) > 0)
			 		
			 		return 1;
			 	
			 	elseif($sent == 0)
			 	
			 		return 2;
			 	
			 	else
			 		
			 		return 0;
		 	}else{
		 			
		 		return 2;
	 			
	 		}
	 	}catch(Exception $e) {
	 	
	 		return 2;
	 	
	 	}	 	
	 	
	 }
	 
}


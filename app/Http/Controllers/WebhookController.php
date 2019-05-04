<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Telegram;
class WebhookController extends Controller
{
    //
	public function handle(Request $request)
	{
		//
		//

		//$updates = Telegram::getWebhookUpdates();
		$updates = Telegram::commandsHandler(true);

		$inMessage = $updates['message'];
		$telegram_id = $inMessage['from']['id'];



		$user = \App\User::where('telegram_id',$telegram_id)->first();

		if(!$user){
			// first time message
			$user = new \App\User;
			$user->first_name = $inMessage['from']['first_name'];
			$user->last_name = $inMessage['from']['last_name'];
			$user->telegram_id = $inMessage['from']['id'];
			$user->save();
		}

		//store the message

		if(array_key_exists('document',$inMessage)){
			$message = new \App\DocMesage;
			$message->file_name = $inMessage['document']['file_name'];
			$message->file_type = $inMessage['document']['mime_type'];
			$message->file_id= $inMessage['document']['file_id'];
			$message->file_size = $inMessage['document']['file_size'];

		}else if(array_key_exists('text',$inMessage)){
			$message = new \App\TextMessage;
			$message->text = $inMessage['text'];
		}

		$message->tel_msg_id = $inMessage['message_id'];
		$message->date = $message['date'];
		$message->save();
		$message->from()->save($user);


		return json_encode($request);
	}
}

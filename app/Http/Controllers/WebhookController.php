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
		Storage::append('file.txt',json_encode($updates));


		return json_encode($request);
	}
}

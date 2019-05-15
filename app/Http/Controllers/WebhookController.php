<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Telegram;
class WebhookController extends Controller
{
    //

    public function handleTest()
    {
        $update = Telegram::getUpdates();

// echo json_encode($update);

        foreach ($update as $updates) {

						// echo json_encode(isset( $updates['messages']));

						// echo json_encode($updates['message']);

            if (!isset($updates['message'])) {
                if (isset($updates['edited_message'])) {
                    if (\App\Message::where('tel_msg_id', $updates['message_id'])->first()) {
                        $curMsg = \App\Message::where('tel_msg_id', $updates['message_id'])->first();

                        $inMessage = $updates['message'];
                        $message   = $curMsg->messagable;
                        if (array_key_exists('document', $inMessage)) {

                            $message->file_name = $inMessage['document']['file_name'];
                            $message->mime_type = $inMessage['document']['mime_type'];
                            $message->file_id   = $inMessage['document']['file_id'];
                            $message->file_size = $inMessage['document']['file_size'];


                        } else if (array_key_exists('text', $inMessage)) {

                            $message->text = $inMessage['text'];

                        } else if (array_key_exists('photo', $inMessage)) {

                            $message->file_id   = $inMessage['photo'][0]['file_id'];
                            $message->file_size = $inMessage['photo'][0]['file_size'];
                            $message->height    = $inMessage['photo'][0]['height'];
                            $message->width     = $inMessage['photo'][0]['width'];
                        } else {
                            continue;
                        }

                        $message->save();

                        //end of copying

                    }

                    return 'Ok';
                }

                return 'O2k';
            }
            $inMessage   = $updates['message'];
            $telegram_id = $inMessage['from']['id'];




            $user = \App\User::where('telegram_id', $telegram_id)->first();

            if (!$user) {
                // first time message
                $user              = new \App\User;
                $user->first_name  = $inMessage['from']['first_name'];
                $user->last_name   = isset($inMessage['from']['last_name']) ? $inMessage['from']['last_name'] : " ";
                $user->telegram_id = $inMessage['from']['id'];
                $user->save();
            }
            if (!\App\Message::where('tel_msg_id', $inMessage['message_id'])->first()) {


                $wrapperMessage             = new \App\Message;
                $wrapperMessage->tel_msg_id = $inMessage['message_id'];
                $wrapperMessage->sent_on    = date('Y-m-d', $inMessage['date']);


                if (array_key_exists('document', $inMessage)) {
                    $message            = new \App\DocMessage;
                    $message->file_name = $inMessage['document']['file_name'];
                    $message->mime_type = $inMessage['document']['mime_type'];
                    $message->file_id   = $inMessage['document']['file_id'];
                    $message->file_size = $inMessage['document']['file_size'];


                } else if (array_key_exists('text', $inMessage)) {
                    $message       = new \App\TextMessage;
                    $message->text = $inMessage['text'];

                } else if (array_key_exists('photo', $inMessage)) {
                    $message            = new \App\Photo;
                    $message->file_id   = $inMessage['photo'][0]['file_id'];
                    $message->file_size = $inMessage['photo'][0]['file_size'];
                    $message->height    = $inMessage['photo'][0]['height'];
                    $message->width     = $inMessage['photo'][0]['width'];
                } else {
                    continue;
                }

                $message->save();

                // $wrapperMessage->user()->save($user);

                $message->message()->save($wrapperMessage);
                $user->messages()->save($wrapperMessage);


            }
        }


        return 'Ok';

    }
    public function handle(Request $request)
    {

        $updates = Telegram::getWebhookUpdates();
        //	$updates = Telegram::commandsHandler(true);

        if (!array_key_exists('message', $updates)) {
            if (array_key_exists('edited_message', $updates)) {
                if (\App\Message::where('tel_msg_id', $updates['message_id'])->first()) {
                    $curMsg = \App\Message::where('tel_msg_id', $updates['message_id'])->first();

                    $inMessage = $updates['message'];
                    $message   = $curMsg->messagable;
                    if (array_key_exists('document', $inMessage)) {

                        $message->file_name = $inMessage['document']['file_name'];
                        $message->mime_type = $inMessage['document']['mime_type'];
                        $message->file_id   = $inMessage['document']['file_id'];
                        $message->file_size = $inMessage['document']['file_size'];


                    } else if (array_key_exists('text', $inMessage)) {

                        $message->text = $inMessage['text'];

                    } else if (array_key_exists('photo', $inMessage)) {

                        $message->file_id   = $inMessage['photo'][0]['file_id'];
                        $message->file_size = $inMessage['photo'][0]['file_size'];
                        $message->height    = $inMessage['photo'][0]['height'];
                        $message->width     = $inMessage['photo'][0]['width'];
                    } else {
                        return 'Ok';
                    }

                    $message->save();

                    //end of copying

                }

                return 'Ok';
            }

            return 'Ok';
        }

        $inMessage   = $updates['message'];
        $telegram_id = $inMessage['from']['id'];

        $user = \App\User::where('telegram_id', $telegram_id)->first();

        if (!$user) {
            // first time message
            $user              = new \App\User;
            $user->first_name  = $inMessage['from']['first_name'];
            $user->last_name   = isset($inMessage['from']['last_name']) ? $inMessage['from']['last_name'] : " ";
            $user->telegram_id = $inMessage['from']['id'];
            $user->save();
        }



        if (!\App\Message::where('tel_msg_id', $inMessage['message_id'])->first()) {
            if (array_key_exists('document', $inMessage)) {
                $message            = new \App\DocMessage;
                $message->file_name = $inMessage['document']['file_name'];
                $message->mime_type = $inMessage['document']['mime_type'];
                $message->file_id   = $inMessage['document']['file_id'];
                $message->file_size = $inMessage['document']['file_size'];


            } else if (array_key_exists('text', $inMessage)) {
                $message       = new \App\TextMessage;
                $message->text = $inMessage['text'];

            } else if (array_key_exists('photo', $inMessage)) {
                $message            = new \App\Photo;
                $message->file_id   = $inMessage['photo'][0]['file_id'];
                $message->file_size = $inMessage['photo'][0]['file_size'];
                $message->height    = $inMessage['photo'][0]['height'];
                $message->width     = $inMessage['photo'][0]['width'];
            } else {
                return 'Ok';
            }

            $message->save();

            $wrapperMessage             = new \App\Message;
            $wrapperMessage->tel_msg_id = $inMessage['message_id'];
            $wrapperMessage->sent_on    = date('Y-m-d', $inMessage['date']);
            // $wrapperMessage->user()->save($user);

            $message->message()->save($wrapperMessage);
            $user->messages()->save($wrapperMessage);

            return 'Successfully Inserted';


        }

    }
}

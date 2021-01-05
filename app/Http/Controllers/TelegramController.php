<?php

namespace App\Http\Controllers;

use Telegram;

class TelegramController extends Controller
{
    public function getUpdates()
    {
        $updates = Telegram::getWebhookUpdates();
        error_log($updates->message->text);
        $response = Telegram::sendMessage([
            'chat_id' => '1084454902',
            'text' => 'Hello World',
        ]);
    }
}

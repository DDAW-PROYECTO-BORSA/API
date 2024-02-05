<?php

namespace App\Http\Controllers;

use App\Http\Services\ChatGPTService;

class OpenAIController extends Controller
{

    public function index()
    {
        $question = "Hola gpt, como te va";
        $chatService = new ChatGPTService();
        $reply = $chatService->response($question);

        dd($reply);
        $message = '';
        foreach ($reply as $r){
            if ($r['message']['role'] == 'assistant') {
                    $message .= $r['message']['content'];
            }
        }
    }
}
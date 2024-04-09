<?php

namespace App\Http\Controllers;

use App\Http\Conversations\OnboardingConversation;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {
            $botman->types();
            if ($message == 'hi') {
                $this->startConversation($botman);
            }else{
                $botman->reply("escribe 'hi' para iniciar...");
            }
        });

        $botman->listen();
    }
    public function startConversation($botman)
    {
        $botman->startConversation(new OnboardingConversation());
    }

}

<?php
use App\Http\Controllers\BotManController;
use Mpociot\BotMan\Middleware\ApiAi;

// Don't use the Facade in here to support the RTM API too :)
$botman = resolve('botman');


$botman->hears('test', function($bot){
    $bot->reply('hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('hola', function($bot) {
    // The incoming message matched the "my_api_action" on API.ai
    // Retrieve API.ai information:
    $extras = $bot->getMessage()->getExtras();
    $apiReply = $extras['apiReply'];
    $apiAction = $extras['apiAction'];
    $apiIntent = $extras['apiIntent'];

    $bot->reply($apiReply);
})->middleware(ApiAi::create(env('APIAI_KEY'))->listenForAction());

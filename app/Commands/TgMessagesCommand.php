<?php

namespace App\Commands;

use App\Application;
use App\Telegram\TelegramApiImpl;

class TgMessagesCommand extends Command {
    public function __construct(public Application $app){
        $this->app = $app;
    }

    public function run(array $options = []):void {
        $tgApp = new TelegramApiImpl($this->app->env('TELEGRAM_TOKEN'));
        echo json_encode($tgApp->getMessages(0));
    }
}
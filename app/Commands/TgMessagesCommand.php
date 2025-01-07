<?php

namespace App\Commands;

use App\Application;
use App\Cache\Redis;
use App\Telegram\TelegramApiImpl;

class TgMessagesCommand extends Command {
    protected Application $app;
    private int $offset;
    private array $oldMessages;
    private Redis $redis;

    public function __construct(Application $app){
        $this->app = $app;
        $this->offset = 0;
        $this->oldMessages = [];
        $client = new \Predis\Client([
            'scheme' => 'tcp',
            'host' => '18.0.0.1',
            'port' => 6379,
        ]);

        $this->redis = new Redis($client);
    }

    public function run(array $options = []):void {
        $tgApp = new TelegramApiImpl($this->app->env('TELEGRAM_TOKEN'));
        echo json_encode($tgApp->getMessages(0));
    }

    private function receiveNewMessages():array {
        $offset = $this->redis->get('tg_messages:offset', 0);
        $tgApi = new TelegramApiImpl($this->app->env('TELEGRAM_TOKEN'));
        $result = $tgApi->getMessages($offset);

        $this->redis->set('tg_messages:offset', $result['offset'] ?? 0);
        $oldMessages = json_decode($this->redis->get('tg_messages:old_messages'));

        $messages = [];

        foreach($result['result'] ?? [] as $chatId => $newMessage){
            if(isset($oldMessages[$chatId])) {
                $oldMessages[$chatId] = [...$oldMessages[$chatId], ...$newMessage];
            } else {
                $oldMessages[$chatId] = $newMessage;
            }
            $messages[$chatId] = $oldMessages[$chatId];
        }

        $this->redis->set('tg_messages:old_messages', json_encode($oldMessages));

        return $messages;
    }
}
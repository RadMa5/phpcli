<?php

namespace App\Commands;

use App\Application;

use App\Database\SQLite;

use App\EventSender\EventSender;

use App\Models\Event;

//use App\Models\EventDto;
use App\Telegram\TelegramApiImpl;

class HandleEventsCommand extends Command

{

    protected Application $app;

    public function __construct(Application $app)

    {

        $this->app = $app;

    }

    public function run(array $options = []): void

    {

        $event = new Event(new SQLite($this->app));

        $events = $event->select();

        $eventSender = new EventSender(new TelegramApiImpl($this->app->env('TELEGRAM')));

        foreach ($events as $event) {

            if ($this->shouldEventBeRan($event)) {

                $eventSender->sendMessage($event['receive_id'], $event['text']);

            }

        }

    }

    public function shouldEventBeRan(array $event): bool

    {
        $currentMinute = date("i");

        $currentHour = date("H");

        $currentDay = date("d");

        $currentMonth = date("m");

        $currentWeekday = date("w");

        return ($event['minute'] === $currentMinute &&

            $event['hour'] === $currentHour &&

            $event['day'] === $currentDay &&

            $event['month'] === $currentMonth &&

            $event['weekDay'] === $currentWeekday);
    }

}
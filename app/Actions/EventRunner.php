<?php

namespace App\Actions;

use App\Models\Event;


class EventSaver {
    public function __construct(private Event $event)
    {
    }

    public function handle(array $eventDto): void {
        $this->saveEvent(
            [
                'name' => $eventDto['name'],
                'receiver_id' => $eventDto['receiverId'],
                'text' => $eventDto['text'],
                'minute' => $eventDto['minute'],
                'hour' => $eventDto['hour'],
                'day' => $eventDto['day'],
                'month' => $eventDto['month'],
                'day_of_week' => $eventDto['weekDay'],
            ]
        );
    }

    private function saveEvent(array $params): void {
        $this->event->insert(
            implode(', ', array_keys($params)),
            array_values($params)
        );
    }
}
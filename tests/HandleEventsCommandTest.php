<?php

use PHPUnit\Framework\TestCase;

class HandleEventCommandTest extends TestCase {
    public function testShouldEventBeRanReceiveEventDtoAndReturnCorrectBool(array $event, bool $shouldEventBeRan): void {
        $handleEventCommand = new \App\Commands\HandleEventsCommand(new \App\Application(dirname(__DIR__)));

        $result = $handleEventCommand->shouldEventBeRan($event);

        self::assertEquals($result, $shouldEventBeRan);
    }

    public static function eventDtoDataProvider(): array {
        return [
            [
                [
                    'minute' => date('i'),
                    'hour' => date('H'),
                    'day' => date('d'),
                    'month' => date('m'),
                    'day_of_week' => date('w')
                ],
                true
            ],
            [
                [
                    'minute' => date('i'),
                    'hour' => date('H'),
                    'day' => date('d'),
                    'month' => date('m'),
                    'day_of_week' => null
                ],
                false
            ]
        ];
    }
}
<?php

use App\Actions\EventSaver;
use App\Models\Event;
use PHPUnit\Framework\TestCase;

class EventSaverTest extends TestCase {
    public function testHandleCallCorrectInsertInModel(array $eventDto, array $expectedArray): void {
        $mock = $this->getMockBuilder(Event::class)
        ->setMethods(['insert'])
        ->disableOriginalConstructor()
        ->getMock();
        $mock->expects($this->once())->method('insert')->with(
            ['name, text, receiver_id, minute, hour, day, month,day_of_week', $expectedArray]
        );

        $eventSaver = new EventSaver($mock);
        $eventSaver->handle($eventDto);

    }

    public static function eventDtoDataProvider(): array {
        return [
            [
                [
                    'name' => 'some-name',
                    'text' => 'some-text',
                    'receiver_id' => 'some-receiver',
                    'minute' => 'minute',
                    'hour' => 'hour',
                    'day' => 'day',
                    'month' => 'month',
                    'day_of_week' => 'day'
                ],
                [
                    'some-name',
                    'some-text',
                    'some-receiver',
                    'minute',
                    'hour',
                    'day',
                    'month',
                    'day'
                ]
            ],
            [
                [
                    'name' => 'some-name',
                    'text' => 'some-text',
                    'receiver_id' => 'some-receiver',
                    'minute' => null,
                    'hour' => null,
                    'day' => null,
                    'month' => null,
                    'day_of_week' => null
                ],
                [
                    'some-name',
                    'some-text',
                    'some-receiver',
                    null,
                    null,
                    null,
                    null,
                    null
                ]
            ]
        ];
    }
}
<?php

use PhpParser\Node\NullableType;
use PHPUnit\Framework\TestCase;

class SaveEventCommandTest extends TestCase {
    public function testisNeedHelp(array $options, bool $testResult) {
        $saveEventCommand = new \App\Commands\SaveEventCommand(new \App\Application(dirname(__DIR__)));

        $result = $saveEventCommand->isNeedHelp(($options));

        self::assertEquals($result, $testResult);
    }

    public function isNeedHelpDataProvider(){
        return [
            [
                [
                    'name' => 'some-name',
                    'text' => 'some-text',
                    'receiver' => 'some-receiver',
                    'cron' => 'some-cron',
                    // 'help',
                    // 'h'
                ],
                false
            ],
            [
                [
                    'name' => 'some-name',
                    'text' => 'some-text',
                    'receiver' => 'some-receiver',
                    'cron' => 'some-cron',
                    'help' => 'some-help',
                    'h' => null
                ],
                true
            ],
            [
                [
                    'name' => 'some-name',
                    'text' => 'some-text',
                    'receiver' => 'some-receiver',
                    'cron' => 'some-cron',
                    'help' => null,
                    'h' => 'some-h'
                ],
                true
            ],
            [
                [
                    'name' => 'some-name',
                    'text' => 'some-text',
                    'receiver' => 'some-receiver',
                    'cron' => null,
                    // 'help',
                    // 'h'
                ],
                true
            ],
            [
                [
                    'name' => 'some-name',
                    'text' => 'some-text',
                    'receiver' => null,
                    'cron' => 'some-cron',
                    // 'help',
                    // 'h'
                ],
                true
            ],
        ];
    }
}
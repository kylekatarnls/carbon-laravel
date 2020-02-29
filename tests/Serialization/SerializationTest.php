<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Tests\CarbonLaravel\TestCase;

class SerializationTest extends TestCase
{
    public function testSerialization()
    {
        if (Carbon::now()->format('m-d') === '02-29') {
            Carbon::setTestNow('-1 day');
        }

        self::assertSame('1 year ago', unserialize(serialize(Carbon::now()->subYear()))->diffForHumans());
    }
}

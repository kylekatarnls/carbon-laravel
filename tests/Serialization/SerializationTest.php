<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Tests\CarbonLaravel\TestCase;

class SerializationTest extends TestCase
{
    public function testSerialization()
    {
        self::assertSame('1 year ago', unserialize(serialize(Carbon::now()->subYear()))->diffForHumans());
    }
}

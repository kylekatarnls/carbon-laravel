<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Tests\CarbonLaravel\TestCase;

class JsonTest extends TestCase
{
    public function testJsonEncoding()
    {
        self::assertSame('1 year ago', Carbon::__set_state(json_decode(json_encode(Carbon::now()->subYear()), true))->diffForHumans());
    }
}

<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Tests\CarbonLaravel\TestCase;

class JsonTest extends TestCase
{
    public function testJsonEncoding()
    {
        $json = json_encode(Carbon::now()->subYear());
        $data = json_decode($json, true);
        self::assertSame('1 year ago', Carbon::__set_state($data)->diffForHumans(), "Set from JSON failed for $json");
    }
}

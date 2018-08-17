<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Tests\CarbonLaravel\TestCase;

class MacroTest extends TestCase
{
    public function testMacro()
    {
        Carbon::macro('verbatim', function ($param) {
            return $param;
        });
        self::assertSame('foo', Carbon::verbatim('foo'));
        self::assertSame('bar', Carbon::now()->verbatim('bar'));
    }

    public function testDynamicCalls()
    {
        self::assertSame(3, Carbon::now()->addMinutes(3)->diffInMinutes());
    }
}

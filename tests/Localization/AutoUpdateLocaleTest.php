<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Tests\CarbonLaravel\TestCase;

class AutoUpdateLocaleTest extends TestCase
{
    public function testAutoUpdateLocale()
    {
        self::assertSame('1 year ago', Carbon::now()->subYear()->diffForHumans());
        app()->setLocale('fr');
        self::assertSame('il y a 1 an', Carbon::now()->subYear()->diffForHumans());
    }
}

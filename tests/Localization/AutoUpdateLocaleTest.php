<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Tests\CarbonLaravel\TestCase;

class AutoUpdateLocaleTest extends TestCase
{
    public function testAutoUpdateLocale()
    {
        self::assertSame('2 years ago', Carbon::now()->subYears(2)->diffForHumans());
        app()->setLocale('fr');
        self::assertSame('il y a 2 ans', Carbon::now()->subYears(2)->diffForHumans());
    }

    public function testAutoUpdateLocaleCarbonImmutable()
    {
        self::assertSame('2 years ago', CarbonImmutable::now()->subYears(2)->diffForHumans());
        app()->setLocale('fr');
        self::assertSame('il y a 2 ans', CarbonImmutable::now()->subYears(2)->diffForHumans());
    }
}

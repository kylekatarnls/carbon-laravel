<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Tests\CarbonLaravel\TestCase;

class AutoUpdateLocaleTest extends TestCase
{
    public function testAutoUpdateLocale()
    {
        if (Carbon::now()->format('m-d') === '02-29') {
            Carbon::setTestNow('-1 day');
        }

        self::assertSame('2 years ago', Carbon::now()->subYears(2)->diffForHumans());
        app()->setLocale('fr');
        self::assertSame('il y a 2 ans', Carbon::now()->subYears(2)->diffForHumans());
    }

    public function testAutoUpdateLocaleCarbonImmutable()
    {
        if (!class_exists(CarbonImmutable::class)) {
            $this->markTestSkipped('CarbonImmutable is version 2 only.');
        }

        if (CarbonImmutable::now()->format('m-d') === '02-29') {
            CarbonImmutable::setTestNow('-1 day');
        }

        self::assertSame('2 years ago', CarbonImmutable::now()->subYears(2)->diffForHumans());
        app()->setLocale('fr');
        self::assertSame('il y a 2 ans', CarbonImmutable::now()->subYears(2)->diffForHumans());
    }
}

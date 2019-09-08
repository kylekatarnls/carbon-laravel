<?php

namespace Tests\CarbonLaravel\Localization;

use Carbon\Carbon;
use Tests\CarbonLaravel\TestCase;

class JsonTest extends TestCase
{
    public function testJsonEncoding()
    {
        // Carbon 1 with PHP 7.4+ needs a hack for JSON serialization
        if (version_compare(PHP_VERSION, '7.4.0-dev', '>=') && !class_exists('Carbon\CarbonInterface')) {
            Carbon::serializeUsing(function ($date) {
                return json_decode(json_encode(new \DateTime($date->format(\Carbon\Carbon::MOCK_DATETIME_FORMAT), $date->getTimezone())), true);
            });
        }

        $json = json_encode(Carbon::now()->subYear());
        $data = json_decode($json, true);
        self::assertSame('1 year ago', Carbon::__set_state($data)->diffForHumans(), "Set from JSON failed for $json");
    }
}

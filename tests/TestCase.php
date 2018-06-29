<?php

namespace Tests\CarbonLaravel;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/app/app.php';

        $app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

        return $app;
    }
}

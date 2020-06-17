<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use DB;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        \App\Models\User::onlyTrashed()->restore();
        \App\Models\BatchOrder::where([
            'status' => [1, 2, 4]
        ])->update(['status' => 0]);

        return $app;
    }
}

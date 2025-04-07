<?php

namespace App\Providers;

use App\Library\Helpers\StringHelper;
use Illuminate\Support\ServiceProvider;

class StringMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        StringHelper::registerMacros();
    }
}

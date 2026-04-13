<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class HelperServicerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    protected function loadhelpers()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            ob_start();
            require_once $filename;
            $unexpectedOutput = ob_get_clean();

            if ($unexpectedOutput !== false && $unexpectedOutput !== '') {
                Log::warning('Unexpected output suppressed while loading helper file.', [
                    'file' => $filename,
                    'bytes' => strlen($unexpectedOutput),
                ]);
            }
        }
    }
}

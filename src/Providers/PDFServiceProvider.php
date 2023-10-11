<?php

namespace PDF\Providers;

use PDF\Contracts\PDFLogicInterface;
use PDF\Logics\PDFLogic;
use Illuminate\Support\ServiceProvider;

class PDFServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PDFLogicInterface::class, PDFLogic::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

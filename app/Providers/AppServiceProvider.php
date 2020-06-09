<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\QnABoardService;
use App\Http\Services\BoardServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BoardServiceInterface::class, function($app) {
            return new QnABoardService('QnABoardService-');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
    }
}

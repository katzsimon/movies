<?php

namespace Katzsimon\Cinema;

use Illuminate\Support\Facades\Route;
use Katzsimon\Cinema\Repositories\BookingRepository;
use Katzsimon\Cinema\Repositories\BookingRepositoryInterface;
use Katzsimon\Cinema\Repositories\ScreeningRepository;
use Katzsimon\Cinema\Repositories\ScreeningRepositoryInterface;
use Katzsimon\Cinema\Repositories\TheatreRepository;
use Katzsimon\Cinema\Repositories\TheatreRepositoryInterface;
use Katzsimon\Cinema\Repositories\CinemaRepository;
use Katzsimon\Cinema\Repositories\CinemaRepositoryInterface;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */


    public function boot()
    {

		Route::model('booking', 'App\Models\Booking');
        Route::model('cinema', 'App\Models\Cinema');
        Route::model('screening', 'App\Models\Screening');
        Route::model('theatre', 'App\Models\Theatre');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');


		$this->loadViewsFrom(__DIR__.'/../resources/views', 'katzsimon');
		$this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Katzsimon\Cinema\Console\Commands\SetupCinemaCommand::class,
            ]);
        }


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(CinemaRepositoryInterface::class, CinemaRepository::class);
        $this->app->bind(ScreeningRepositoryInterface::class, ScreeningRepository::class);
        $this->app->bind(TheatreRepositoryInterface::class, TheatreRepository::class);
    }

}

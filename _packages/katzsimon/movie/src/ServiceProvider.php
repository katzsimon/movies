<?php

namespace Katzsimon\Movie;


use Illuminate\Support\Facades\Route;
use Katzsimon\Movie\Repositories\MovieRepository;
use Katzsimon\Movie\Repositories\MovieRepositoryInterface;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */


    public function boot()
    {

        Route::model('movie', 'App\Models\Movie');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'katzsimon');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Katzsimon\Movie\Console\Commands\SetupMovieCommand::class,
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
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }

}

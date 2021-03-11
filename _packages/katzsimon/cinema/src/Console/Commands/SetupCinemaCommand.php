<?php

namespace Katzsimon\Cinema\Console\Commands;

use Illuminate\Console\Command;
use Katzsimon\Base\Services\Extend;
use Katzsimon\Base\Services\Publish;

class SetupCinemaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cinema:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup files for the Cinema package.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $baseDir = __DIR__.'/../..';

        Extend::model($baseDir.'/Models/Booking.php');
        Extend::model($baseDir.'/Models/Cinema.php');
        Extend::model($baseDir.'/Models/Screening.php');
        Extend::model($baseDir.'/Models/Theatre.php');

        Extend::controller($baseDir.'/Http/Controllers/BookingController.php');
        Extend::controller($baseDir.'/Http/Controllers/CinemaController.php');
        Extend::controller($baseDir.'/Http/Controllers/ScreeningController.php');
        Extend::controller($baseDir.'/Http/Controllers/TheatreController.php');

        Extend::controller($baseDir.'/Http/Controllers/FactoryController.php');

        Extend::controller($baseDir.'/Http/Controllers/AppBookingController.php');
        Extend::controller($baseDir.'/Http/Controllers/AppController.php');

        Extend::request($baseDir.'/Http/Requests/AdminBookingRequest.php');
        Extend::request($baseDir.'/Http/Requests/AdminCinemaRequest.php');
        Extend::request($baseDir.'/Http/Requests/AdminScreeningRequest.php');
        Extend::request($baseDir.'/Http/Requests/AdminTheatreRequest.php');
        Extend::request($baseDir.'/Http/Requests/AppBookingRequest.php');


        Publish::factory($baseDir.'/../database/factories/BookingFactory.php');
        Publish::factory($baseDir.'/../database/factories/CinemaFactory.php');
        Publish::factory($baseDir.'/../database/factories/ScreeningFactory.php');
        Publish::factory($baseDir.'/../database/factories/TheatreFactory.php');

        Publish::test($baseDir.'/../tests/Unit/BookingRepositoryTest.php');
        Publish::test($baseDir.'/../tests/Unit/CinemaRepositoryTest.php');
        Publish::test($baseDir.'/../tests/Unit/ScreeningRepositoryTest.php');
        Publish::test($baseDir.'/../tests/Unit/TheatreRepositoryTest.php');
        Publish::test($baseDir.'/../tests/Feature/BookingTest.php');
        Publish::test($baseDir.'/../tests/Feature/CinemaTest.php');
        Publish::test($baseDir.'/../tests/Feature/ScreeningTest.php');


        return 0;
    }
}

<?php

namespace Katzsimon\Movie\Console\Commands;

use Illuminate\Console\Command;
use Katzsimon\Base\Services\Extend;
use Katzsimon\Base\Services\Publish;

class SetupMovieCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the files for the Movie package.';

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

        Extend::model($baseDir.'/Models/Movie.php');

        Extend::controller($baseDir.'/Http/Controllers/MovieController.php');

        Extend::request($baseDir.'/Http/Requests/AdminMovieRequest.php');

        Publish::factory($baseDir.'/../database/factories/MovieFactory.php');

        $this->line('Movie Package has been setup');

        return 0;
    }
}

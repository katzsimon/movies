<?php

namespace Katzsimon\Base\Console\Commands;

use Illuminate\Console\Command;
use Katzsimon\Base\Services\Extend;
use Katzsimon\Base\Services\Publish;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'base:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the Base package.';

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

        Extend::model($baseDir.'/Models/Model.php', ['force'=>true]);

        Extend::controller($baseDir.'/Http/Controllers/Controller.php', ['root'=>true, 'force'=>true]);
        Extend::controller($baseDir.'/Http/Controllers/AdminController.php');
        Extend::controller($baseDir.'/Http/Controllers/AppController.php');

        return 0;
    }
}

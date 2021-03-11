<?php

namespace Katzsimon\Auth\Console\Commands;

use Illuminate\Console\Command;
use Katzsimon\Base\Services\Extend;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the Auth package.';

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

        Extend::controller($baseDir.'/Http/Controllers/AdminAuthController.php');
        Extend::controller($baseDir.'/Http/Controllers/AppAuthController.php');

        Extend::request($baseDir.'/Http/Requests/AdminLoginRequest.php');
        Extend::request($baseDir.'/Http/Requests/AdminRegisterRequest.php');
        Extend::request($baseDir.'/Http/Requests/AppLoginRequest.php');
        Extend::request($baseDir.'/Http/Requests/AppRegisterRequest.php');

        $this->line('Auth Package has been setup');
        return 0;
    }
}

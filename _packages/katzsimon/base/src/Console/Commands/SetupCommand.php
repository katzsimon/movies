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

        Publish::view($baseDir.'/../resources/views/templates/admin_nav.blade.php');
        Publish::view($baseDir.'/../resources/views/templates/app_nav.blade.php');
        Publish::view($baseDir.'/../resources/views/pages/admin/dashboard.blade.php');
        Publish::view($baseDir.'/../resources/views/pages/app/account.blade.php');
        Publish::view($baseDir.'/../resources/views/pages/app/home.blade.php');

        // Admin Resources
        Publish::resource($baseDir.'/../resources/js/templates/AdminNav.vue');
        Publish::resource($baseDir.'/../resources/js/pages/admin/Dashboard.vue');

        // App Resources
        Publish::resource($baseDir.'/../resources/js/plugins/router_routes.js');
        Publish::resource($baseDir.'/../resources/js/templates/AppNav.vue');
        Publish::resource($baseDir.'/../resources/js/pages/app/Home.vue');
        Publish::resource($baseDir.'/../resources/js/pages/app/Account.vue');

        Publish::test($baseDir.'/../tests/BaseCRUDTest.php');
        Publish::test($baseDir.'/../tests/BaseRepositoryTest.php');

        $this->line('Base Package has been setup');

        return 0;
    }
}

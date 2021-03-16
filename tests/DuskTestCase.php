<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    // Need to manually change env files if running tests through PHPStorm
    protected $envChange = true;


    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless',
                '--window-size=1920,1080',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function hasHeadlessDisabled()
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
               isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }


    public function setUp():void
    {

        parent::setUp();

        /*
         * Change the env files manually if running test via PHPStorm
         *
         * Renaming:
         * .env -> .env.temp
         * .env.dusk.local -> .env
         */
        if ($this->envChange && !file_exists(base_path('.env.temp')) && file_exists(base_path('.env.dusk'))) {
            rename(base_path('.env'), base_path('.env.temp'));
            copy(base_path('.env.dusk'), base_path('.env'));
        }

    }

    public function tearDown():void
    {
        parent::tearDown();

        /*
         * Restore the env files after testing
         *
         * Renaming:
         * delete .env
         * .env.temp -> .env
         */
        if ($this->envChange && file_exists(base_path('.env.temp')) && file_exists(base_path('.env'))) {
            unlink(base_path('.env'));
            rename(base_path('.env.temp'), base_path('.env'));
        }

    }


}

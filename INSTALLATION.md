
# Movie Booking Assignment - Installation Instructions

## Quick Install
    0) Setup a MySql/MariaDB database
    1) Download or git clone https://github.com/katzsimon/movies
    2) Copy .env.example to .env
    3) Run: composer update
    4) Update .env file
    4.1) Set APP_KEY or run: php artisan key:generate
    4.2) Set database access credentials
    4.3) Set APP_URL
    5) php artisan migrate
    6) php artisan db:seed (optional)
    7) npm install
    8) npm run prod
    9) Browse to: APP_URL for the App
    9.1) Browse to: APP_URL/admin for the Admin CRUD 

###
___

## More detailed explanation of the setup
 
### Laravel Customization/Setup
* Rename public to public_html (For deployment later)
    - Laravel mix setPublicPath to public_html (in webpack.mix.js)
    - /app/Providers/AppServiceProvider: bind new public_path
* /config/app: change timezone to 'Africa/Johannesburg'
* /config/database: 'strict' => false & 'engine' => 'InnoDB'
    * Disable strict mode for MySQL (To not use Null values, works better with Form-Model bindings)
    * /app/Http/Kernel: Remove ConvertEmptyStringsToNull::class Middleware,
* /config/filesystems: public -> public_html & adding 'base' disk
* /app/Providers/AppServiceProvider:
    * Add Schema::defaultStringLength(191), needed for my local development for default key length
* /config/settings.php: config file used for settings used for this app
* /config/auth.php: guards.api.driver => env('API_GUARD', 'sanctum')==='sanctum' ? 'token' : 'passport'
* /app/Http/Kernel: $middlewareGroups.api: Add EnsureFrontendRequestsAreStateful & $routeMiddleware: add 'auth.admin'
    * Add \Katzsimon\Base\Http\Middleware\Protect::class to the web middleware group, if you are going to use the Protect (most probably unnecessary, as just added to password protect https://www.webengineer.co.za)
    * Set the PROTECT_ENABLED & PROTECT_PASSWORD env variables if you are going to use this

### Custom Packages

Add custom packages to composer.json

    "autoload": {
        "psr-4": {
            "Katzsimon\Base\": "_packages/katzsimon/base/src",
            "Katzsimon\Auth\": "_packages/katzsimon/auth/src",
            "Katzsimon\Movie\": "_packages/katzsimon/movie/src",
            "Katzsimon\Cinema\": "_packages/katzsimon/cinema/src"
        }
    },

Run the following to install/publish the package files into the app.   
If the packages are updated, these commands will setup/publish possible new assets  
See PACKAGE_NAME/src/Console/Commands/SetupCommand for what is setup in the corresponding package 

    php artisan base:setup
    php artisan auth:setup
    php artisan movie:setup
    php artisan cinema:setup
    


### Laravel Packages Used/Installed
- laravelcollective/html
    - composer require laravelcollective/html
- inertiajs/inertia-laravel
    - composer require inertiajs/inertia-laravel
- tightenco/ziggy
    - composer require tightenco/ziggy
- laravel/passport
    - composer require laravel/passport
    - php artisan migrate
    - php artisan passport:install
    - App\Models\User.php: use Laravel\Passport\HasApiTokens
    - App\Providers\AuthServiceProvider: See code to add in boot method
- laravel/sanctum
    - composer require laravel/sanctum
    - php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    - php artisan migrate
    - App\Models\User.php: use Laravel\Sanctum\HasApiTokens
- barryvdh/laravel-debugbar
    - composer require barryvdh/laravel-debugbar --dev
    - php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
    - .env: DEBUGBAR_ENABLED=false
- beyondcode/laravel-query-detector
    - composer require beyondcode/laravel-query-detector --dev
    - php artisan vendor:publish --provider="BeyondCode\QueryDetector\QueryDetectorServiceProvider"
    - .env: QUERY_DETECTOR_ENABLED=false
- laravel/dusk
    - composer require --dev laravel/dusk
    - php artisan dusk:install
    - php artisan dusk:chrome-driver [optional: version if needed]
- nunomaduro/larastan
    - composer require --dev nunomaduro/larastan
    - create: /phpstan.neon
    - php vendor/phpstan/phpstan/phpstan analyse

### Node Packages Installed:
- tailwindcss
    - npm install -D tailwindcss@latest postcss@latest autoprefixer@latest
    - create: /tailwind.config.js
- @inertiajs/inertia
    - npm install @inertiajs/inertia @inertiajs/inertia-vue
    - npm install @inertiajs/progress
- bootstrap-vue
    - npm install vue bootstrap bootstrap-vue
- vue
    - npm install vue
- vue-meta
    - npm install vue-meta --save
- vue-router
    - npm install vue-router
- vuex
    - npm install vuex --save
- vuetify
    - npm install vuetify

### Compile Resources
* See **Env Files** in [README.md](README.md) for more details about the environment variables
* Ensure APP_URL and/or MIX_APP_URL is set in env file
    * Use MIX_APP_URL set to http://localhost:3000 if you are going to use 'npm run watch'
* Set MIX_MODE for what will be compiled: 'both', 'app' or 'admin'    

Then

    'npm run prod' or 'npm run dev'

###
___
## Testing
* Setup a separate database to use for testing.
* Copy the .env file to:
    * .env.testing
    * .env.dusk

* Ensure these env variables are set correctly/appropriate for testing


    DEBUGBAR_ENABLED=false  
    QUERY_DETECTOR_ENABLED=false  
    MIX_PACKAGES_PATH="_packages/katzsimon"  
    OUTPUT_APP=vueapp  
    OUTPUT_ADMIN=inertia
    API_GUARD=sanctum  
    PROTECT_ENABLED=false
    DB_CONNECTION=mysql  
    DB_HOST=127.0.0.1  
    DB_PORT=3306  
    DB_DATABASE=  
    DB_USERNAME=  
    DB_PASSWORD=  

    
If not using DatabaseMigrations Trait in the tests, run the following to migrate the testing database 

    php artisan migrate --env=testing

To run all the Feature and Unit Tests

    php artisan test

To run a specific test
    
    php artisan test --filter [NAMETest]

### Browser Tests
* When running tests through PHPStorm and with hitting API end points, I have setup the base DuskTestCase to swap out the .env file for the .env.dusk while the tests are running 
  * See the comments in DuskTestCase::setUp and DuskTestCase::tearDown for more details


To run the Browser Tests for Blade


    Set env:
    OUTPUT_APP=blade
    OUTPUT_ADMIN=blade

    Then:
    php artisan dusk --filter=blade


To run the Browser Tests for Vue

    Set env:
    OUTPUT_APP=vueapp
    OUTPUT_ADMIN=inertia

    Then:
    php artisan dusk --filter=vue

    
### Additional Parallel Race Tests
* These 2 test are excluded from the other by default as they should be run in parallel
    * Prepare 2 Terminals to run the 2 tests at the same time
    * You will have 10 seconds to start the 2nd test after the 1st one has started
    * The 1st test will pause for 10 seconds in the Booking process
        * The 2nd test should wait until the 1st test has complete to attempt making its Booking
    * The expected outcome is that the 1st test will successfully book all the seats and that the 2nd test will return with an error, that no seats are available


```
    Terminal 1: php artisan test tests/Race/BookingRace1SuccessTest.php
    Terminal 2: php artisan test tests/Race/BookingRace2ErrorTest.php
```


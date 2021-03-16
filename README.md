# Movie Booking Assignment
Senior Developer Assignment

## Requirements
* Using HTML / CSS / JS / PHP and MySQL, you are to create a functional Movie Booking System that will allow users to view and book screenings online, for a specified film, at a specified cinema, at a specified show time. You may use any form of framework or tool, be it front-end or back-end, as long as you can justify its use. (Bootstrap, Angular, VueJS, Laravel, Symfony, etc.)
1.  Users should be able to register and log in.
2.  Users should be logged in to complete a booking, but can view and select whilst unauthenticated.
3.  Users should be given a unique booking reference number to use as a redemption method. (No need to mail it, displaying it will be fine.)
4.  Users should be able to view their booking specifics after having booked.
5.  Users should be able to cancel a booking up until one hour before the show starts.
6.  Cinema theaters have a maximum number of 30 seats.
7.  When booking, a user only needs to choose a cinema, a film, a show time, and the number of tickets. (Use whichever display method and process / flow you like best, simple dropdowns will do as well.)
* This serves as a minimum specification, and you may add or expand on functionality if you wish, as long as the minimum specification is met.

#### Nice-to-Haves
* An admin CRUD for each data entity
* Testable Code
* SOLID principles followed
* Clean commented code

#### Assumptions:
* There are only two cinema locations, each has two theatres, with two films currently showing.
    * *I have setup a Admin CRUD so these limits are unnecessary*
* Users won’t need to pay.
* Environment: Feel free to use whatever you like.

#### Tasks: 
* Give a brief explanation about what you used, and why. This may include the tools and frameworks you made use of, or any methodologies/best practices you incorporated whilst developing, on the application and DB level.
  * *See below in "[My Approach](#my-approach)"*
* Create a public Github / Bitbucket repository, which should contain your completed project and all related files, regular small commits will allow us to better follow your work.
  * *Full Disclosure: As I wanted to use this assignment to experiment with some things, and with my own requirements the project got a little more involved, I did build/test most things separately/locally and then mostly simulated my workflow in a repository afterwards. Because of this you might see some bigger commits and some future code appearing earlier* 
* Deliver a functional project, with all files included and instructions for setting it up.
 	* The functional project is available at: https://www.webengineer.co.za
	* *Please contact me for the password to access it*
	* *See [Installation instructions](INSTALLATION.md) for setting up the project*

### My Own Extra Requirements
*  Not use my existing code
*  To experiment a little and setup the project to have different outputs (Blade, JSON, Inertia, Vue) from the same basic code
*  Run Vue from Laravel/Blade and not a Node server
    *  Want reloading a page/refreshing to keep you on the page you were on    
*  Use the followings packages/frameworks 
    *  VueJS with Vuetify for the App
    *  InertiaJS for the Admin CRUD 
    *  Tailwind for most of the CSS
        * Use Bootsrap for additional components/functionality where needed        
        * *I am not a big fan of Tailwind (especially if one knows CSS well), but can use it. I am definitely up to debate this.*
* Both Admin CRUD and App to be interchangeable with standard Laravel Blade from the same code base
	*  Easier and quicker to build/debug/test with Blade  	
	*  Use environment variables and HTTP headers to switch between different outputs
    *  Code will format/cast data and return types/redirects automatically done in the background to keep Controller code clean and simple
* Extract common code/components/ui elements into their own reusable components
* Interchange Laravel Sanctum and Laravel Passport for API Authentication Tokens
* Password protect the deployed application 
* Testing
    * Have Extendable CRUD tests
    * Have Extendable Repository tests
    * Have Laravel Dusk tests to work with Blade, Vue, Inertia and API


##
## My Approach
* Modify standard Laravel install with my requirements
    * Run on Windows for development and cPanel for Deployment/Production
    * Rename public -> public_html
* Create separate packages to split up into re-usable but extendable modules
    * These would normally be separate Git/Composer repositories but including them locally in the repository for this assignment (in the _packages directory)
    * The Packages:
        * **Base**: Base Framework/Scaffolding
        * **Auth**: Handle the different base Authentication code for the different systems
        * **Movie**: Generic Movie Package
        * **Cinema**: Handles functionality for a Cinema
            * Cinemas, Theatres in the Cinemas, Screenings of Movies, Bookings of Movies
      #####
        * Package Installations/Setup:
            * Each package has a packagename:setup Artisan function to install it (extra functionality than Laravel built in Publishing)
				* Example: php artisan base:setup
                * Controllers, Models and Requests are extended into the main app, to allow changing/additional functionality for the app
                * Factories, seeders, resources, tests are published into the app
        * Each Package has a README file for more information about that specific Package
			* [Base README](_packages/katzsimon/base/README.md)
            * [Auth README](_packages/katzsimon/auth/README.md)
            * [Movie README](_packages/katzsimon/movie/README.md)
            * [Cinema README](_packages/katzsimon/cinema/README.md)


___

#### General Structure / Overview
* This is primarily a backend assignment, so there was less emphasis put on the frontend/design
* There are many more improvements that can still be made to this project, but they are out of the scope of this assignment
  
  
* I tried to match up directories and file names for Blade and Vue files, so they can be mostly interchangeable and equivalent, while trying to stick to corresponding naming conventions
    *  **Common Blade & Vue Notes**
    * templates directory: Components that relate to the layout/page structure of the app
    * pages admin/app directories: Contains the main pages
    * components directory: General UI Components that are reused in different places
    * plugins directory: Contains the setup code for the different JavaScript/Vue plugins/packages.
      * Cleaner and easier to work with them separately and to re-use them with the app and admin code where needed
    * **Blade Notes**
    * Created a FormField Blade Component for form elements
    * Load the correct blade view or blade vue app/route when needed
        * You can refresh a page in a Vue app and it will return to where it was
    * Easier to overwrite/add app functionality in the app views/vendor directory (E.g. admin_nav, dashboard)
    * File names are Snake Case
    * **Vue Notes**
    * middleware directory: Contains middleware functions
    * mixins directory: Mixins to setup repeated/reused functionality
    * Have to publish and link to app components in the app resources (E.g. AppNav, Home, Account)
    * Vue component file names are Pascal Case
    
* **Security**
    * The Auth package handles most of the basic security requirements
        * There is plenty more that can be added and improved to this but it is out of the scope of this assignment
        * The same user can access/register on the app and Admin CRUD
    * See the [Auth README](_packages/katzsimon/auth/README.md) for more details
    
* **Database**
    * Used the standard MySQL/MariaDB for the database
    * Tables are setup with foreign keys and indexes
    * Factories, with states are used to create necessary data
    * Database Transaction and Locking used to prevent the double booking race condition
        * See /cinema/src/Controllers/AppBookingController/handleBooking() 
    
* **Routes**
    * Each package has a web & api routes file    
    * Package API routes are enclosed in an 'api' group as they are not automatically enclosed like in the main app
    * The API routes are mostly duplicates of web routes with token middleware guards
        * With the automatic formatting/switching of the responses, the web routes can be used instead of the API routes (besides the authentication)
        * Example: "request-source: vue" or "force-content-type: json" HTTP Headers can be used
      
* **Controllers**
    * I extend the package Controllers into app, so the app can over ride or add functionality
    * The Katzsimon\Base\Http\Controllers\Controller contains the main functionality
      * See [Base README](_packages/katzsimon/base/README.md) for more details
    * App prefixed Controllers are for the front end apps, Admin prefixed or Model named Controllers are for the Admin CRUD
    * I prefer to group similar functionality into 1 controller, than to have lots of separate ones
        * E.g. Auth Controller handles login, registration and logging out, instead of 3 separate Controllers for this
    
* **Requests**
    * Form Validation is handled by FormRequests
    * Works the same for blade and Vue validations
    * Extended into main app to allow for customization of the package in the app
    
* **Models**
    * Extended into main app to allow for customization in the app
    * See [Base README](_packages/katzsimon/base/README.md) for more details
    
* **Repositories**
    * Base Repository and Interface in Base package that contains common data functionality
    * Each Model has their extended Repository that handles its additional data requirements
    * All Data setting/getting is done through the Repositories
    
* **Resources**
    * Eloquent Resources are used to cast Model data into JSON/Arrays for consistent responses/data between blade and API
    
* **Services**
    * Contains classes for custom functionality
        * Only used for Extending and Publishing package files in base package
    
* **Tests**
    * Packages publish their tests to the main app, so they can all be run with "php artisan test"
        * Or they can be run individually from the package
    * I like to have a separate testing database that is not migrated between tests
        * This is the same SQL database - so you are actually testing the same platform as production
        * sqlite does not work well with migrations/updating tables that are not null
        * Useful to look at the database/data when debugging and building tests
            * Most tests have a $truncateTables variable used to clear data between tests
            * Can easily be set to false and DatabaseMigrations or DatabaseTransactions used instead
        * *Ensure .env is copied to .env.testing with the testing database specified*
        * *Ensure PROTECT_ENABLED=false*
        * *JSON output is forced with HTTP headers from the tests*
        * *See [Installation instructions / Testing](INSTALLATION.md) for more details*
    * **Feature**
        * Testing more complex functionality and app entry points
        * Each CRUD extends the BaseCRUDTest for standard resource methods and then additional required tests are added when needed
    * **Race**
        * To test the race condition for multiple users booking the same seats
        * They are excluded from the standard test suite and should be run manually as they should be run in  parallel 
        * *See [Cinema README](_packages/katzsimon/cinema/README.md) for more details*
        
    * **Unit**
        * Testing more single methods, focussed functionality 
        * Each Repository extends the BaseRepositoryTest and additional tests for additional data repository methods are added 
    * **Browser**
        * Laravel Dusk used to check functionality actually works in the Browser
        * Tests have a Blade or Vue Suffix to target the corresponding outputs
            * Needed as Blade and Vue/Vuetify require different ways of interacting with the UI elements
            * You can run just the Blade or Vue tests
                * php artisan dusk --filter=vue
                * php artisan dusk --filter=blade
        * *Ensure .env is copied to .env.dusk with the testing database specified, and the desired OUTPUTS set*
    
* **Env Files**
    * Custom variables are:
      
        * MIX_APP_URL =
            * Optional, defaults to APP_URL
            * Use to set the base path for HTTP/API requests, allows you to set http://localhost:3000 during development
        * MIX_PACKAGES_PATH = sets the base path for the packages
        * MIX_MODE = sets the output of 'npm run' to either app, admin or both
            * Speeds up not recompiling uneeded resources 
        * OUTPUT_APP = sets the output of the app. Either 'vueapp' or 'blade'
        * OUTPUT_ADMIN = sets the output of the admin CRUD. Either 'inertia' or 'blade'
        * API_GUARD = sets API token method to use. Either 'sanctum' or 'passport'
        * PROTECT_ENABLED = enables password protection for the app
            * Only used for demonstration purposes and not part of the actual app 
        * PROTECT_PASSWORD = sets the password for protection
        *- If these packages are installed/used, keep these set to false unless needed
            * DEBUGBAR_ENABLED=false
            * QUERY_DETECTOR_ENABLED=false

* **Webpack**
    * Custom aliases are set in webpack.config.js
    * setPublicPath used to output to public_html instead of public
    * Admin and App resources can be compiled separately (to speed up compilation) or together
    * Sass used for custom css and Tailwind



## More Reading:
* [Installation instructions](INSTALLATION.md)
* [Base README](_packages/katzsimon/base/README.md)
* [Auth README](_packages/katzsimon/auth/README.md)
* [Movie README](_packages/katzsimon/movie/README.md)
* [Cinema README](_packages/katzsimon/cinema/README.md)

# Base Package
### Handles all the Base functionality for the system


## Resources
### CSS
* Common CSS elements are split and grouped, they start with an underscore _    
    * buttons, cards, forms, general, layout, tables, toast
    * The CSS is mostly built with Tailwind
* **admin.scss**
    * Contains the custom CSS needed for the Admin CRUD
* **app.scss**
    * Contains the custom CSS needed for the App

### JS
* **admin.js** the main JavaScript entry point for the Admin CRUD
  * The resolveComponent() method/prop converts the blade view path to the corresponding Vue component path
* **app.js** the main JavaScript entry point for the App
* **Components** contains the base Vue Components that the rest of the app is built from
    * Components and mixins have been setup to make building and scaffolding the rest of the app quicker
    * If a common heading/component/functionality needs to change, it can be done in the base component and it will update every where it is used
* **Mixins** contain the common functionality used for the CRUD
    * Central place to store and change the common data and methods
* **Pages** contain the relevant page content
    * They will extend templates and use components 
* **Templates** contain the components that have to do with the page structure
* **Plugins**
    * Separating the common importing and setting up of JavaScript/Vue plugins and packages 

### Views
* **admin.blade.php**
    * The main blade file for the Admin CRUD
    * It will render the Blade page or the Inertia App depending on what is outputted
* **app.blade.php**
    * The main blade file for the App
    * It will render the Blade page or the Vue App depending on what is outputted
* **protect.blade.php**
    * Displays the Password form for the Protect Middleware
* **components directory**
    * Contains the reusable individual blade components
* **pages directory**
    * Contains the data for the admin and app pages in their corresponding directories
* **templates directory**
    * Contains the blade files responsible for general page layout/structure
    

## Controllers
**Controller**  
The main part of the application is the Base Controller at /_packages/katzsimon/base/src/Http/Controllers/
* output():
    * Determines what the needed output is  
    * Formats output data so it is consistent and quicker/easier to return
    * Collections are put in 'data'
    * Single Model is put in 'item'
    * Models and Collections are automatically cast to their JSON Resources
    * Sets up UI and Breadcrumbs data where needed
    * Manages the output of a controller: Blade View, Blade Layout, Inertia or JSON
        * Converts  
* redirect():
    * Manages the appropriate redirection between HTTP/Blade, Inertia, JSON/Vue from the same code base
* getUI():
    * Builds the UI data needed from the default Model, used/reused in many places for less typing 
* getBreadcrumbs():
    * Automatically builds the Breadcrumbs used in the Admin CRUD from the Model
    
**AdminController**  
* The main entry point to the Admin CRUD
    * Redirects to the Login Page
    * Displays the Dashboard
        * This is extended in the main app to provide the Dashboard functionality needed for this particular app
        * Shows Upcoming Bookings and allows the User to run Factories (Makes testing the App easier)
**AppController**
* The main entry point to the App
    * Displays the Home page
        * This is extended in the main app to provide the data needed to be displayed on the Home page of the app
        * Shows some Featured Movies and if the User is logged in and has Upcoming Bookings
    * Displays the Account page
        * This is extended in the main app to provide the Account functionality needed for this particular app
        * It will show the Upcoming and Past Bookings for the User
    
**ProtectController**  
* Handles the Password Protection process of the demo app
* Not really part of the actual App


## Models
The base Model that all others extend
* getUI(): Builds array of data for UI elements for the model. See DocBlock for more info.
* getBreadcrumbs(): Automatically builds the array for the breadcrumbs items in the Admin CRUD

## Repositories
**BaseRepository**
* Contains the common Data/Model/Database manipulations needed for all the Models in this app
* Every Model will have it's own Repository that extends from this Base
    * Additional Data methods for the particular Model are added to the Models Repository
    
**BaseRepositoryInterface**
* The Interface/Contract for the BaseRepository
    * Ensures that the Repository implements the required methods 
* Used for the ServiceProvider to bind the associated Repository via Dependency Injection 

## Services
**Extend**
* Enables packages to extend their Models/Controllers/Requests into the main app, to enable easy customisation of the packages functionality if needed
    * Used in the package:setup console command 

**Publish**
* Copies certain package files/assets into the main app
    * Used in the package:setup console command

## Tests
**Unit/OutputTest**
* Checks that the base Controllers output method works correctly and casts the data correctly

**BaseCRUDTest**
* An abstract test for each Admin CRUD to be based on
    * The main test will set the required Model and Base URL in its setUp() method
* This will test the common CRUD functionality needed for each resource
* Additional required tests can be added in the corresponding Test
* Tests the following:
    * index
    * store
    * update
    * show
    * destroy
* Requests and Responses use Json
* Checks the validity of the data in the database matches the test

**BaseRepositoryTest**
* An abstract test for each models Repository to be based on
  * The main test will set the required Repository in its setUp() method
* Tests the following:
    * Retrieves the Model
    * Creates a Model
    * Updates a Model
    * Finds a Model by its key
    * Tests retrieving a subset (limit)
    * Tests that it can return a Model with empty attributes
* Extra helper methods used in the tests
    * matchModels(): Check that the attributes in a source model match those in a target model
        * Some attributes can be different after a model has been saved/processed
    * matchArrays(): Check that all the attrivutes in a source array exist in a target array
    * hasEmptyAttributes(): Check that all the attributes in a model are empty

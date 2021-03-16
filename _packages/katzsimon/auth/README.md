# Authentication Package
###Handles all the Authentication functionality

*There is obviously a lot more that can be added to this package, but it is out of the scope of this project*

###
###Authentication Methods Used
* Blade: Standard Laravel Illuminate\Support\Facades\Auth methods used
* Inertia: Authentication information is passed via the HandleInertiaRequests Middleware
* API: Laravel Sanctum/Passport tokens used for API Authentication
* Vue: Created simple Middleware to handle authentication in the app


###
### Controllers
* AdminAuthController
    * Handles the login/registration/logout of the Admin CRUD
* AppAuthController
    * Handles the login/registration/logout of the App
    

###
### Middleware
* src/Http/Middleware/AuthenticateAdmin used to redirect to admin login, on admin authentication fail
    * In a proper app this would contain more authorization functionality
* resources/js/middleware/auth setup and used as Vue Middleware to handle protected Vue routes
    * Combination of VueX Store and Local Storage used for this  

###
###Switching Between Sanctum and Passport
To switch between Sanctum API Tokens and Passport API Tokens, you only need to use the corresponding in  app/Models/User

    use Laravel\Sanctum\HasApiTokens;
    or
    use Laravel\Passport\HasApiTokens;

and set the API_GUARD env variable to
    
    API_GUARD=sanctum
    or 
    API_GUARD=passport

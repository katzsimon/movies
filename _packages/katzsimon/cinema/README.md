# Cinema Package
### Handles all the Cinema related functionality and data
* **Cinemas**
    * A Cinema has many Theatres 
* **Theatres**
    * Has a maximum number of seats
    * Additional seats can be added and made available to book 
* **Screenings**
    * The date, time and location of when/where a Movie will be screened  
* **Bookings**
    * Associates a User with a Screening
    * Can only be cancelled before a certain amount of minutes before the Screening
        * The number of minutes is set in the Models cancelMinutesThreshold (default is 60) 
    
##
**Things that deviate from the standard functionality are mentioned below**

### Controllers
**AppBookingController**
* Manages a User making a booking for a Screening in the app
* There are different ways this can be initiated
    1) The User can go straight to the Booking page 
        * URL: /booking
        * No Movie or Screening is selected
        * The User then needs to start with choosing a Movie, Screening, seats to book
    2) The User can be sent from Movie page
        * URL: /booking/movie/MOVIE_ID
        * A movie is already selected, and the Screenings for that Movie is loaded
        * The User then needs to chose a Screening and the seats to book
    3) The User can be sent from a Screening list
        * URL: /booking/screening/SCREENING_ID 
        * The Movie and Screening are already selected
            * The selected Movie comes from the selected Screening 
        * The User just needs to choose the seats
* Depending on the state/selection, the URL will change/be redirected to reflect the current selection
    * This allows the state/selection to be tracked through the process
    * The User will not lose their selection on a failed booking attempt or page reload
* Only the current number of available seats for the selected screening are loaded

**AppController**
* Most of the pages in the app will be loaded from here
* This will load the relevant combination of the Cinemas, Theatres, Screenings and Movies

**TheatreController**
* As the Theatre Model belongs to a Cinema, there are different URLs/Breadcrumbs/UI elements needed for a nested resource
* The system has been setup so that the flow is practically the same as a non nested resource, and the differences are mostly compensated for behind the scenes in the components/templates and base Controller/Model  

### Models
**Booking**
* Contains method to cancel a Booking, if it is able to be cancelled
* The same method can be used to check if a booking can be cancelled without actually cancelling it
    * Useful to check if a Cancel Button should be shown
* If the Reference is empty when a Booking is created, it will create a random string for the Reference 

**Screening**
* The datetime field removes the seconds when it is displayed
    * Seconds are never used for Movie Screening times
* The seats_available attribute checks the maximum number of seats in the Theatre and sums the current seats booked for the Screening
    * This allows the correct number to be displayed, if additional seats are added to the Theatre or someone cancels their booking 
      
### Repositories
**ScreeningRepository**
* The Repository that is mostly used in the app
* There are different ways that the Screening and Movie information relating to Screenings are needed
    * Most data required for the app needs the Movie and Screening data, so most of the 'Movie Calls' are done through the ScreeningRepository to keep the Movie package decoupled

## Factories
The factories have some additional states

**BookingFactory**
* past(): Create a Booking with a Screening that happened in the past
* user(): Create a Booking assigned to a specific User
* dateTime(): Create a Booking with a Screening at a specific time

**CinemaFactory**
* There are arrays with random Cinema Locations and Names
* The factory will choose from these randomly

**ScreeningFactory**
* randomTime(): This will choose a realistic random Screening time
    * Hours are between 10am and 10pm
    * Minutes and seconds are set to 0
* past(): Create a Screening that happened in the past
* movie(): Create a Screening for a specified Movie
* dateTime(): Create a Screening at a specific time


### Testing
**Race/BookingRaceTests**
* To test for the race condition that multiple users cannot book the same seats at the same time
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

**BookingTest**
* Tests that Bookings can be cancelled
* Tests that Bookings cannot be cancelled within the cancelMinutesThreshold



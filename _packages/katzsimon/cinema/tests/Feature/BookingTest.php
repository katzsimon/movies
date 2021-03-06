<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookingTest extends \Tests\BaseCRUDTest
{

    protected $repository = null;
    protected $skipBaseTests = true;
    protected $truncateTables = false;

    public function setUp():void
    {

        $this->model = app()->make(\App\Models\Booking::class);
        $this->baseUrl = '/admin/bookings';

        $this->repository = app()->make(\Katzsimon\Cinema\Repositories\BookingRepository::class);

        parent::setUp();

    }

    public function truncate()
    {
        if ($this->truncateTables) {
            DB::table('screenings')->truncate();
            DB::table('movies')->truncate();
            DB::table('cinemas')->truncate();
            DB::table('theatres')->truncate();
        }
    }


    /**
     * Check that a future Booking can be cancelled
     * This is effectively testing the cancelBooking method in the Model
     */
    public function testCanCancelBooking() {

        $booking = $this->repository->model()->factory()->create();

        $this->assertTrue($booking->cancelBooking(false));

    }

    /**
     * Check that a Booking can be cancelled
     * This actually cancels the Booking
     */
    public function testCancelBooking() {

        $booking = $this->repository->model()->factory()->create();

        $this->assertTrue($booking->cancelBooking());
    }


    /**
     * Check that a Booking can't be cancelled within 60 minutes of its Showing
     */
    public function testCancelBookingWithinThresholdMins() {
        $booking = $this->repository->model()->factory()->dateTime(Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s'))->create();

        $this->assertFalse($booking->cancelBooking());
    }

}

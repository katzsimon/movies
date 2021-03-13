<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CancelBookingsTest extends TestCase
{
    use DatabaseTransactions;

    protected $repository = null;


    public function setUp():void
    {
        parent::setUp();

        $this->repository = app()->make(\Katzsimon\Cinema\Repositories\BookingRepository::class);
    }

    /**
     * Check that a future Booking can be cancelled
     * This is effectively testing the cancelBooking method in the Model
     */
    public function testCanCancelBooking() {

        $booking = $this->repository->model()->factory()->create();

        $this->assertTrue($booking->cancelBooking(true));

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
     * Check that a Booking can't be cancelled within the threshold of its Showing
     *      Threshold is set in the Model
     */
    public function testCancelBookingWithinThreshold() {
        $booking = $this->repository->model()->factory()->dateTime(Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s'))->create();

        $this->assertFalse($booking->cancelBooking());
    }



}

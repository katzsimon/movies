<?php

namespace Katzsimon\Cinema\Repositories;

use App\Models\Booking;
use App\Models\Cinema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Katzsimon\Base\Repositories\BaseRepository;
use Katzsimon\Base\Repositories\BaseRepositoryInterface;


class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{

    /**
     * BookingRepository constructor.
     * @param Booking $model
     */
    public function __construct(Booking $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all Upcoming Bookings
     * Used in the Admin Dashboard page
     *
     * @param int $limit
     * @param string $order
     * @return Collection
     */
    public function getUpcoming($limit=5, $order='asc'): Collection
    {
        return $this->newQuery()
            ->with('user')
            ->join('screenings', 'bookings.screening_id', '=', 'screenings.id')
            ->where('screenings.datetime', '>=', Date('Y-m-d H:i:s'))
            ->orderBy('screenings.datetime', $order)
            ->limit($limit)
            ->get();
    }

    /**
     * Get only the Upcoming Bookings for a specific User
     *
     * @param int $userId
     * @param string $order
     * @return Collection
     */
    public function getByUserUpcoming($userId=0, $order='asc'): Collection
    {

        return $this->newQuery()
            ->with('screening')
            ->with('user')
            ->join('screenings', 'bookings.screening_id', '=', 'screenings.id')
            ->where('bookings.user_id', $userId)
            ->where('screenings.datetime', '>', Date('Y-m-d H:i:s'))
            ->select('*', 'bookings.id as id')
            ->orderBy('screenings.datetime')
            ->get();
    }

    /**
     * Get only the Past Bookings for a specific User
     *
     * @param int $userId
     * @param string $order
     * @return Collection
     */
    public function getByUserPast($userId=0, $order='asc'): Collection
    {

        return $this->newQuery()
            ->with('screening')
            ->with('user')
            ->join('screenings', 'bookings.screening_id', '=', 'screenings.id')
            ->where('bookings.user_id', $userId)
            ->where('screenings.datetime', '<', Date('Y-m-d H:i:s'))
            ->select('*', 'bookings.id as id')
            ->orderBy('screenings.datetime')
            ->get();
    }

}

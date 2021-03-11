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


}

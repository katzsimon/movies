<?php namespace App\Http\Controllers\Katzsimon\Base;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Katzsimon\Cinema\Resources\BookingResource;

class AdminController extends \Katzsimon\Base\Http\Controllers\AdminController
{

    public function dashboard(Request $request) {
        if (Auth::check()) {

            $bookingRepository = app()->make('Katzsimon\Cinema\Repositories\BookingRepository');

            $breadcrumbs =  [];

            $breadcrumbs =[
                [
                    'text'=>'Admin',
                    'href'=>'/admin/dashboard'
                ],
                [
                    'text'=>'Dashboard',
                    'href'=>'/admin/dashboard'
                ],
                [
                    'text'=>Auth::user()->name.' : '.Auth::user()->email,
                    'href'=>'/admin/dashboard'
                ]
            ]
            ;

            $data = [
                'bookings'=>BookingResource::collection($bookingRepository->getUpcoming())->toArray(request())
            ];


            return $this->output(['view'=>'katzsimon::pages.admin.dashboard', 'data'=>$data, 'breadcrumbs'=>$breadcrumbs]);
        }
        return $this->redirect(['route'=>'admin.login']);
    }

}

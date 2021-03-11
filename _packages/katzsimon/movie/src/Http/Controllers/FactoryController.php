<?php

namespace Katzsimon\Movie\Http\Controllers;

use App\Http\Requests\AdminMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Katzsimon\Base\Http\Controllers\Controller;
use Katzsimon\Movie\Repositories\MovieRepositoryInterface;


/**
 * Allows Running Factories from the Admin section
 *
 * Class FactoryController
 * @package Katzsimon\Movie\Http\Controllers
 */
class FactoryController extends Controller
{

    protected $admin = true;


    /**
     * Create Movie models
     *
     * @param Request $request
     * @param Movie $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function makeMovie(Request $request, Movie $item)
    {
        $number = $request->get('numberMovie', 1);

        $outputs = $item->factory($number)->create();

        return $this->redirect(['route'=>'admin.dashboard', 'message'=>['type'=>'success', 'message'=>"{$number} Movies Created"]]);

    }

}

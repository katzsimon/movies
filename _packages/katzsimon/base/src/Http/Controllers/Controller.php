<?php

namespace Katzsimon\Base\Http\Controllers;

use Countable;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class Controller extends BaseController
{

    protected $repository;      // Default Repository
    protected $resource;        // Default Resource
    protected $ui = [];         // The UI details for the default Model
    protected $model = null;    // The default Model
    protected $defaultOutput = null;    // Force a default output if needed
    protected $admin = false;   // Specify if the Controller is used for the App or Admin Section

    /**
     * Setup default model and UI data
     *
     * Controller constructor.
     */
    public function __construct() {
        if (isset($this->model) && !empty($this->model)) {
            $model = new $this->model;
            $this->ui = $model->getUI();
        }
    }


    public function output($options=[]) {

        $debug = $options['debug'] ?? false;

        $json = false;
        if (
            request()->header('force-content-type')==='json' ||
            request()->header('force-content-type')==='application/json' ||
            request()->header('content-type')==='json' ||
            request()->header('content-type')==='application/json' ||
            request()->header('http-accept')==='json' ||
            request()->header('http-accept')==='application/json' ||
            request()->header('request-source')==='vue'
        ) $json = true;

        $view = $options['view'] ?? '';

        $output = $options['output'] ?? request()->get('output', '');

        if (empty($output) && $json) $output = 'json';
        if (empty($output)) $output = config($this->getOutput());


        if (isset($this->model)) {
            $model = new $this->model;
            $ui = $model->getUI();
        } else {
            $model = false;
            $ui = false;
        }


        $parent = $options['parent'] ?? null;
        if (!empty($parent)) $data['parent'] = $parent;

        $breadcrumbs = $options['breadcrumbs'] ?? [];
        if ($breadcrumbs!==false && !empty($model)) {
            if (Str::contains($view, 'index')) {
                $breadcrumbs = $model->getBreadcrumbs('index', ['parent'=>$parent]);
            } elseif(Str::contains($view, 'edit')) {
                $breadcrumbs = $model->getBreadcrumbs('edit', ['parent'=>$parent]);
            } elseif(Str::contains($view, 'create')) {
                $breadcrumbs = $model->getBreadcrumbs('create', ['parent'=>$parent]);
            }
        }


        $with = $options['with'] ?? null;
        $message = $with['message'] ?? $options['message'] ?? null;
        if (!empty($message)) {
            if (is_array($message)) $message = json_encode($message);
            session()->flash('message', $message);
        }

        $resource = $options['resource'] ?? $this->resource;

        $items = $options['items'] ?? null;
        $item = $options['item'] ?? null;

        $data = $options['data'] ?? [];

        $data['items'] = $data['items'] ?? $items ?? null;
        $data['item'] = $data['item'] ?? $item ?? null;
        $data['parent'] = $data['parent'] ?? $parent ?? null;

        if (is_null($data['items'])) unset($data['items']);
        if (is_null($data['item'])) unset($data['item']);
        if (is_null($data['parent'])) unset($data['parent']);

        if (!empty($resource)) {
            ////
            // Map items to array
            if (isset($data['items']) && count($data['items'])>0) {
                if (!is_array($data['items']) && get_class($data['items'])==='Illuminate\Database\Eloquent\Collection') {
                    $data['items'] = call_user_func($resource . '::collection', $data['items']);
                }
                if (!is_array($data['items']) && get_class($data['items'])==='Illuminate\Http\Resources\Json\AnonymousResourceCollection') {
                    $data['items'] = $data['items']->toArray(request());
                }
            }


            // Map Item to array
            if ( isset($data['item']) && is_subclass_of($data['item'], 'Illuminate\Database\Eloquent\Model') ) {
                // Convert Eloquent Model into Resource Array

                $theResource = new $resource($data['item']);
                $arrayResource = $theResource->toArray(request());
                $data['item'] = $arrayResource;
            } elseif (isset($data['item']) && is_subclass_of($data['item'], 'Illuminate\Http\Resources\Json\JsonResource')) {
                // Convert Eloquent Resource into Resource Array
                $arrayResource = $data['item']->toArray(request());
                $data['item'] = $arrayResource;
            }

        }

        // Rename items to data
        if (isset($data['items']) && !isset($data['data'])) {
            $data['data'] = $data['items'];
            unset($data['items']);
        }

        $data['breadcrumbs'] = $breadcrumbs;
        $data['ui'] = $ui;



        if ($output==='blade') {
            // Return the blade view

            if (!empty($parent)) $data['parent'] = $parent;
            $data['output'] = 'blade';

            return view($view, $data);
        }
        if ($output==='json') {
            // Return the output as json

            return json_encode($data);
        }

        abort(404, 'No valid output found');

    }

    public function redirect($options=[]) {

        $route = $options['route'] ?? '';
        $parameters = $options['params'] ?? [];

        $output = $options['output'] ?? request()->header('force-content-type')??'';
        $source = $options['source'] ?? request()->header('request-source')??'';

        if (empty($output)) $output = config($this->getOutput());

        $with = $options['with'] ?? null;
        $message = $with['message'] ?? $options['message'] ?? null;
        if (!empty($message)) {
            if (is_string($message) && substr($message, 0, 1)!=='{') $message = ['message'=>$message];
            if (is_array($message)) $message = json_encode($message);

            session()->flash('message', $message);
        }


        if ($output==='json' || $source==='vue') {
            // Return json instead of redirecting

            $data = $options['data'] ?? [];

            if (isset($options['item']) && !isset($data['item'])) $data['item'] = $options['item'];
            if (isset($options['items']) && !isset($data['items'])) $data['items'] = $options['item'];

            return json_encode($data);
        }

        if (!empty($route)) {

            // Redirect to intended route if exists (with authentication fail), or specified route
            if (!empty($parameters)) {
                return Redirect::intended(route($route, $parameters));
            } else {
                return Redirect::intended(route($route));
            }

        }


        return Redirect('/');

    }


    public function getUI($model=null) {
        if (empty($model)) $model = $this->model;
        $modelInstance = new $model;
        return $modelInstance->getUI();
    }

    public function isCountable($data=null)
    {
        return is_array($data) || $data instanceof Countable;
    }

    public function counted($data=null)
    {
        if ($this->isCountable($data)) {
            return count($data);
        }
        return 0;
    }

    public function getOutput()
    {
        if ($this->admin) return 'settings.output.admin';
        return 'settings.output.app';
    }

}

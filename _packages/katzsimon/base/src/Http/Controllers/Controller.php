<?php

namespace Katzsimon\Base\Http\Controllers;

use Countable;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

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


    /**
     * Prepare request data and output it in the required format
     *
     * @param array $options
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|string
     */
    public function output($options=[]) {

        $debug = $options['debug'] ?? false;

        // Check headers if JSON is the required output
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

        // Checks if a view has been set
        $view = $options['view'] ?? '';

        // Checks if an output has been specified
        $output = $options['output'] ?? request()->get('output', '');
        // If not then, determine what output is needed
        if (empty($output) && $json) $output = 'json';
        if (empty($output)) $output = config($this->getOutput());

        // If a base Model is set in the Controller, Instantiates the Model and gets it UI data
        if (isset($this->model)) {
            $model = new $this->model;
            $ui = $model->getUI();
        } else {
            $model = false;
            $ui = false;
        }

        $component = $options['component'] ?? '';
        $parent = $options['parent'] ?? null;
        if (!empty($parent)) $data['parent'] = $parent;

        // Build the breadcrumbs
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

        // Formats a flashed message if it has been set
        $with = $options['with'] ?? null;
        $message = $with['message'] ?? $options['message'] ?? null;
        if (!empty($message)) {
            if (is_array($message)) $message = json_encode($message);
            session()->flash('message', $message);
        }

        // The base Eloquent Resource to use
        $resource = $options['resource'] ?? $this->resource;


        // Checks for the commons data items
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

        if ($output==='inertia') {
            // Returns the output for Inertia

            if (empty($component) && !empty($view)) {
                list($namespace, $path) = explode('::', $view);

                $paths = explode('.', $path);
                $package = $paths[1] ?? '';
                $last = count($paths)-1;
                $paths[$last] = ucwords($paths[$last]);
                $path = implode('/', $paths);

                $component = "katzsimon::{$package}::".$path;
            }

            return Inertia::render($component, $data);
        }

        if ($output==='vueapp') {
            // Returns the output for Vue

            $view = 'katzsimon::app';

            $data['output'] = 'vue';

            return view($view, $data);
        }

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


    /**
     * Handle redirects appropriately for the required output method
     *
     * @param array $options
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function redirect($options=[]) {

        $route = $options['route'] ?? '';
        $parameters = $options['params'] ?? [];

        // Check if the request came from Inertia
        $inertia = request()->header('x-inertia')==='true';

        // Check if the output is set from a HTTP header
        $output = $options['output'] ?? request()->header('force-content-type')??'';

        // Check if the source has been specified
        $source = $options['source'] ?? request()->header('request-source')??'';

        // Determine the output needed
        if ($inertia) $output = 'inertia';
        if (empty($output)) $output = config($this->getOutput());

        // Formats the Flashed message if it is set
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


            if ($inertia && Str::contains($route, 'index')) {
                // Redirect for Inertia
                $ui = $this->getUI();
                //dd($ui);
                if (!empty($parameters)) {
                    // If there is a parent model, build the URL with the parent id
                    $urlIndex = str_replace('{params}', $parameters[0], $ui['url_index']);
                    $urlIndex = config('settings.url').$urlIndex;
                } else {
                    // Redirect to the standard index URL
                    $urlIndex = $ui['url_index'];
                }
                return Redirect::to($urlIndex);
            }

            // Redirect to intended route if exists (with authentication fail), or specified route
            if (!empty($parameters)) {
                return Redirect::intended(route($route, $parameters));
            } else {
                return Redirect::intended(route($route));
            }

        }


        return Redirect('/');

    }


    /**
     * Get the UI data from the base Model set in the Controller
     *
     * @param null $model
     * @return mixed
     */
    public function getUI($model=null) {
        if (empty($model)) $model = $this->model;
        $modelInstance = new $model;
        return $modelInstance->getUI();
    }

    /**
     * Check if a variable can be used with count()
     *
     * @param mixed $data
     * @return bool
     */
    public function isCountable($data=null)
    {
        return is_array($data) || $data instanceof Countable;
    }

    /**
     * Return the count() of a variable if it is countable
     * Returns 0 otherwise
     *
     * @param mixed $data
     * @return int
     */
    public function counted($data=null)
    {
        if ($this->isCountable($data)) {
            return count($data);
        }
        return 0;
    }

    /**
     * Get the default output set in the config file
     *
     * @return string
     */
    public function getOutput()
    {
        if ($this->admin) return 'settings.output.admin';
        return 'settings.output.app';
    }

}

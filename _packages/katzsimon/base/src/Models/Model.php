<?php namespace Katzsimon\Base\Models;


use Illuminate\Support\Str;

class Model extends \Illuminate\Database\Eloquent\Model
{

    protected $ui = [];

    /**
     * Setup and return the UI elements needed
     * item = lowercase model name used in bindings
     * items = plural item
     * name = display name for model
     * names = plural name
     *
     * parent-item, parent-name is the equivalent for the models parent, if it belongs to another model
     *
     * title = Heading/Title to display
     * url_index = The URL for the admin index of the model, needed for breadcrumbs
     *
     * @return array
     */
    public function getUI() {
        $ui = $this->ui;
        $ui['items'] = $ui['items'] ?? $ui['item'].'s';

        $ui['name'] = $ui['name'] ?? ucwords($ui['item']);
        $ui['names'] = $ui['names'] ?? Str::plural($ui['name']);

        if (isset($ui['parent'])) {
            $ui['parent-item'] = $ui['parent-item'] ?? $ui['parent'];
            $ui['parent-items'] = $ui['parent-items'] ?? Str::plural($ui['parent-item']);

            $ui['parent-name'] = $ui['parent-name'] ?? ucwords($ui['parent']);
            $ui['parent-names'] = $ui['parent-names'] ?? Str::plural($ui['parent-name']);
        }

        $ui['title'] = $ui['title'] ?? $ui['names'];
        $ui['url_index'] = $ui['url_index'] ?? config('settings.url.spa')."/admin/{$ui['items']}/";
        return $ui;
    }

    public function getBreadcrumbs($type='index', $options=[]) {

        $admin = $options['admin'] ?? true;
        $breadcrumbs = $options['breadcrumbs'] ?? [];
        $parent = $options['parent'] ?? null;

        if ($admin) $breadcrumbs[] = [
            'text'=>'Admin',
            'href'=>'/admin/dashboard'
        ];

        $ui = $this->getUI();

        if (!empty($parent)) {
            $breadcrumbs[] = [
                'text'=>$ui['parent-names'],
                'href'=>"/admin/{$ui['parent-items']}"
            ];

            $breadcrumbs[] = [
                'text'=>$parent->name??$parent->title,
                'href'=>"/admin/{$ui['parent-items']}/{$parent->id}/edit"
            ];
        }

        $breadcrumbs[] = [
            'text'=>$ui['names'],
            'href'=>"/admin/{$ui['items']}"
        ];

        if ($type==='index') {
            $breadcrumbs[] = [
                'text'=>"All {$ui['names']}",
                'active'=>true
            ];
        } elseif ($type==='edit') {
            $breadcrumbs[] = [
                'text'=>"Update",
                'active'=>true
            ];
        } elseif ($type==='create') {
            $breadcrumbs[] = [
                'text'=>"Create",
                'active'=>true
            ];
        } else {
            $breadcrumbs[] = [
                'text'=>ucwords($type),
                'active'=>true
            ];
        }

        return $breadcrumbs;

    }

}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormField extends Component
{
    public $message;
    public $name;
    public $type;
    public $label;
    public $id;
    public $info;
    public $error = '';
    public $options;
    public $placeholder;
    public $readonly;
    public $class;
    public $style;
    public $value;
    public $dataAttribs;
    public $fieldonly;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message='', $name='', $type='', $label='', $id='', $options=[], $value='', $readonly=null, $placeholder=null, $fieldonly=false, $class='', $style=null)
    {
        $this->message = $message;
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->options = $options;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->style = $style;
        $this->readonly = $readonly;
        $this->fieldonly = $fieldonly;
        $this->id = !empty($id) ? $id : $name;
        $this->dataAttribs = [];
        if (session()->has('errors') && session()->get('errors')->has($this->name)) {
            $this->error = session()->get('errors')->get($this->name)[0]??'';
        }
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form-field');
    }
}

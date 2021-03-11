

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'id',
	'label'=>'ID',
	'readonly'=>true
])

@include('katzsimon::components.formfield', [
	'type'=>'select',
	'name'=>'cinema_id',
	'label'=>'Cinema',
	'value'=>$create ? $parent->id : $item->parent_id??null,
	'options'=>\App\Models\Cinema::options(['parent'=>$parent])
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'name',
	'label'=>'Name',
])

@include('katzsimon::components.formfield', [
	'type'=>'number',
	'name'=>'max_seats',
	'value' => $create ? 30 : $item->max_seats??30,
	'label'=>'Maximum Number of Seats',
])

@include('katzsimon::components.item_submit', [
	'item'=>$ui['items'],
])

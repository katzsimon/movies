

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'id',
	'label'=>'ID',
	'readonly'=>true
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'location',
	'label'=>'Location',
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'name',
	'label'=>'Name',
])

@include('katzsimon::components.item_submit', [
	'item'=>$ui['items'],
])

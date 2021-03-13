@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'id',
	'label'=>'ID',
	'readonly'=>true
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'name',
	'label'=>'Name',
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'starring',
	'label'=>'Starring',
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'genre',
	'label'=>'Genre',
])

@include('katzsimon::components.formfield', [
	'type'=>'number',
	'name'=>'runtime',
	'label'=>'Runtime (minutes)',
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'rating',
	'label'=>'Rating',
])

@include('katzsimon::components.formfield', [
	'type'=>'textarea',
	'name'=>'description',
	'label'=>'Description',
])

@include('katzsimon::components.item_submit', [
	'item'=>$ui['items'],
])



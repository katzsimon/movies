

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'id',
	'label'=>'ID',
	'readonly'=>true
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'datetime',
	'label'=>'When',
	'class'=>'diesel',
	'data'=>['mode'=>'datetime', 'format'=>'YYYY-MM-DD HH:mm']
])

@include('katzsimon::components.formfield', [
	'type'=>'select',
	'name'=>'movie_id',
	'label'=>'Movie',
	'value'=>$create ? null : $item['movie_id'],
	'options'=>$movie_options
])

@include('katzsimon::components.formfield', [
	'type'=>'select',
	'name'=>'theatre_id',
	'label'=>'Theatre',
	'value'=>$create ? null : $item['theatre_id'],
	'options'=>$theatre_options
])



@include('katzsimon::components.item_submit', [
	'item'=>$ui['items'],
])

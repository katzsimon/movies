

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'id',
	'label'=>'ID',
	'readonly'=>true
])

@include('katzsimon::components.formfield', [
	'type'=>'select',
	'name'=>'user_id',
	'label'=>'User',
	'value'=>$create ? '' : $item->user_id??null,
	'options'=>\App\Models\User::options()
])

@include('katzsimon::components.formfield', [
	'type'=>'select',
	'name'=>'screening_id',
	'label'=>'Screening',
	'value'=>$create ? '' : $item->screening_id??null,
	'options'=>\App\Models\Screening::options()
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'seats',
	'label'=>'Seats',
])

@include('katzsimon::components.formfield', [
	'type'=>'text',
	'name'=>'reference',
	'label'=>'Reference',
	'info'=>'Leave empty to create automatically'
])


@include('katzsimon::components.item_submit', [
	'item'=>$ui['items'],
])

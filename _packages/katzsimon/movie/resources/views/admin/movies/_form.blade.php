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


<div>
    <button type="submit" class="text-white bg-blue-600 py-2 px-3 inline-block rounded hover:no-underline hover:bg-blue-700">Submit {{ $ui['name']??'' }}</button>
    <a href="{{ route("admin.{$ui['items']}.index") }}" class="text-white bg-gray-400 py-2 px-3 inline-block rounded hover:no-underline hover:bg-gray-600">Cancel</a>
</div>



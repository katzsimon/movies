@php
    $buttonText = $buttonText ?? '';
    if (empty($buttonText)) {
    	if (strpos(url()->current(), 'create')!==false) {
    		$buttonText = 'Create';
    	} else {
    		$buttonText = 'Update';
    	}
    }
@endphp
<div>
    <button type="submit" class="text-white bg-blue-600 py-2 px-3 inline-block rounded hover:no-underline hover:bg-blue-700">{{ $buttonText }} {{ $ui['name']??'' }}</button>
    <a href="@if(isset($parent)) {{ route("admin.{$parent->getUI()['items']}.{$ui['items']}.index", $parent) }} @else {{ route("admin.{$item}.index") }} @endif" class="text-white bg-gray-400 py-2 px-3 inline-block rounded hover:no-underline hover:bg-gray-600">Cancel</a>
</div>

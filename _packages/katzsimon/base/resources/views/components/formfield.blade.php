@php
    $class = $class ?? '';
    $value = $value ?? null;
    $readonly = $readonly ?? null;
    $placeholder = $placeholder ?? null;
    $type = $type ?? 'text';
    $rows = $rows ?? 3;
    $info = $info ?? '';

    $data = $data ?? [];

    $dataAttribs = [];
    foreach($data as $key=>$attrib) {
        $dataAttribs["data-{$key}"] = $attrib;
    }

    $error = '';
    if (session()->has('errors')) $error = session()->get('errors')->get($name, [])[0]??'';
@endphp

<div class="frm-group mb-4">

    <label for="{{ $name }}" class="control-label">{{ $label }}</label>
    <div class="flex w-full flex-col">
        <div class="flex w-full">
            @if($type==='text')
                {!! Form::text($name, $value, array_merge([
	                            'class'=>"form-control {$class}",
	                            'placeholder'=>$placeholder,
	                            'readonly'=>$readonly,
	                            ], $dataAttribs)) !!}
            @elseif($type==='number')
                {!! Form::number($name, $value, [
	                            'class'=>"form-control {$class}",
	                            'placeholder'=>$placeholder,
	                            'readonly'=>$readonly,
	                            ]) !!}
            @elseif($type==='password')
                {!! Form::password($name, [
	                            'class'=>"form-control {$class}",
	                            'placeholder'=>$placeholder,
	                            'readonly'=>$readonly,
	                            ]) !!}
            @elseif($type==='textarea')
                {!! Form::textarea($name, $value, [
	                            'class'=>"form-control {$class}",
	                            'placeholder'=>$placeholder,
	                            'readonly'=>$readonly,
	                            'rows'=>$rows
	                            ]) !!}
            @elseif($type==='select')
                {!! Form::select($name, $options, $value, [
	                            'class'=>"form-control {$class}",
	                            'placeholder'=>$placeholder,
	                            'readonly'=>$readonly,
	                            ]) !!}
            @endif

        </div>
        @if(!empty($info))
            <div class="text-gray-400 text-sm">{{ $info }}</div>
        @endif
        @if(!empty($error))
            <div class="text-red-600">{{ $error }}</div>
        @endif
    </div>
</div>

@if($fieldonly===false)
    <div class="frm-group mb-4">
        <label for="{{ $name }}" class="control-label">{{ $label }}</label>
        <div class="flex w-full flex-col">
            <div class="flex w-full">
@endif
                @if($type==='text')
                    {!! Form::text($name, $value, array_merge([
                                    'class'=>"form-control {$class}",
                                    'placeholder'=>$placeholder,
                                    'readonly'=>$readonly,
                                    'value'=>$value,
                                    'style'=>$style,
                                    'id'=>$id
                                    ], $dataAttribs)) !!}
                @elseif($type==='number')
                    {!! Form::number($name, $value, [
	                                'id'=>$id,
                                    'class'=>"form-control {$class}",
                                    'placeholder'=>$placeholder,
                                    'value'=>$value,
                                    'style'=>$style,
                                    'readonly'=>$readonly,
                                    ]) !!}
                @elseif($type==='password')
                    {!! Form::password($name, [
	                                'id'=>$id,
                                    'class'=>"form-control {$class}",
                                    'placeholder'=>$placeholder,
                                    'readonly'=>$readonly,
                                    'style'=>$style,
                                    'value'=>$value,
                                    ]) !!}
                @elseif($type==='textarea')
                    {!! Form::textarea($name, $value, [
	                                'id'=>$id,
                                    'class'=>"form-control {$class}",
                                    'placeholder'=>$placeholder,
                                    'readonly'=>$readonly,
                                    'value'=>$value,
                                    'style'=>$style,
                                    'rows'=>$rows
                                    ]) !!}
                @elseif($type==='select')
                    {!! Form::select($name, $options, $value, [
	                                'id'=>$id,
                                    'class'=>"form-control {$class}",
                                    'placeholder'=>$placeholder,
                                    'readonly'=>$readonly,
                                    'style'=>$style,
                                    'value'=>$value,
                                    ]) !!}
                @endif
@if($fieldonly===false)
            </div>
            @if(!empty($info))
                <div class="text-gray-400 text-sm">{{ $info }}</div>
            @endif
            @if(!empty($error))
                <div class="text-red-600">{{ $error }}</div>
            @endif
        </div>
    </div>
@endif

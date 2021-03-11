@if(is_array($breadcrumbs) && count($breadcrumbs)>0)
<ol class="breadcrumb flex flex-row justify-end">
@foreach($breadcrumbs as $breadcrumb)
    <li class="inline">
        @if(!empty($breadcrumb['href']))
            <a href="{{ $breadcrumb['href'] }}" class="@if(!empty($breadcrumb['active']??false)) active @endif">
                {{ $breadcrumb['text']??'' }}
            </a>
        @else
            <span class="text-blue-500">
                {{ $breadcrumb['text']??'' }}
            </span>
        @endif

        @if(!$loop->last)<span class="mx-2"> / </span> @endif
    </li>
@endforeach
</ol>
@endif

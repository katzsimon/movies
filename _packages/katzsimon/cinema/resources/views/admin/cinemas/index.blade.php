@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection

@section('breadcrumbs')
    @include('katzsimon::components.breadcrumbs', ['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')

    <div class="box">

        <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center w-24">ID</th>
                <th class="">Name</th>
                <th class="">Location</th>
                <th class="">
                    @include('katzsimon::components.item_create', ['item'=>$ui['items'], 'name'=>$ui['name']])
                    {{--
                    <layout-item-create :item="ui.items" :name="ui.name"></layout-item-create>
                    --}}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td class="center">{{ $item['id']??'' }}</td>
                    <td>{{ $item['name']??'' }}</td>
                    <td>{{ $item['location']??'' }}</td>
                    <td class="">
                        <a href="{{ route("admin.cinemas.theatres.index", $item['id']) }}" class="rounded-md border border-gray-300 shadow-sm px-2 py-1.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 relative" style="top:-3px;">Theatres ({{ $item['theatres_count'] }})</a>
                        @include('katzsimon::components.item_menu', ['id'=>$item['id'], 'name'=>$ui['name']])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

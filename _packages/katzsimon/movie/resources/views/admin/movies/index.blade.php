@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection

@section('breadcrumbs')
    @include('katzsimon::components.breadcrumbs', ['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')

    <div class="box">
        <div class="mb-2">
            @foreach($genres as $genre)
                <a href="{{ route('admin.movies.index.genre', [$genre['title']??'']) }}" class="text-blue-400 hover:text-blue-700 hover:no-underline mr-3 inline-block">{{ $genre['title']??'' }} ({{ $genre['count']??0 }})</a>
            @endforeach
        </div>
        <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center">ID</th>
                <th>NAME</th>
                <th>GENRE</th>
                <th class="text-center">RATING</th>
                @include('katzsimon::components.item_index_extra_cols')
                <th class="">
                    @include('katzsimon::components.item_create', ['item'=>$ui['items'], 'name'=>$ui['name']])
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td class="center">{{ $item['id']??'' }}</td>
                    <td>{{ $item['name']??'' }}</td>
                    <td>{{ $item['genre']??'' }}</td>
                    <td class="text-center">{{ $item['rating']??'' }}</td>
                    @include('katzsimon::components.item_index_extra_cols')
                    <td class="">
                        @include('katzsimon::components.item_menu', ['id'=>$item['id'], 'name'=>$ui['name']])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

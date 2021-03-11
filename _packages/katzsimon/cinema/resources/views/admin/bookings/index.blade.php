@extends('katzsimon::templates.admin_index')


@section('content')

    <div class="box">

        <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center w-24">ID</th>
                <th class="">User</th>
                <th class="">Screening</th>
                <th class="">Seats</th>
                <th class="">Reference</th>
                <th class="">
                    @include('katzsimon::components.item_create', ['item'=>$ui['items'], 'name'=>$ui['name']])
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td class="center">{{ $item['id']??'' }}</td>
                    <td>
                        {!! $item['user_details'] !!}
                    </td>
                    <td>
                        {!! $item['screening_theatre'] !!}<br>
                        <strong>{!! $item['screening_movie'] !!}</strong><br>
                        {!! $item['screening_when'] !!}
                    </td>
                    <td>{{ $item['seats']??'' }}</td>
                    <td>{{ $item['reference']??'' }}</td>
                    <td class="">
                        @include('katzsimon::components.item_menu', ['id'=>$item['id'], 'name'=>$ui['name']])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

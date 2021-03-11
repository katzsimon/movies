@extends('katzsimon::templates.admin_index')


@section('content')

    <div class="box">

        <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center w-24">ID</th>
                <th class="">Name</th>
                <th class="">Max Seats</th>
                <th class="">Cinema</th>
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
                    <td>{{ $item['max_seats']??'' }}</td>
                    <td>{{ $item['cinema_name']??'' }}</td>
                    <td class="">
                        @include('katzsimon::components.item_menu', ['id'=>$item['id'], 'name'=>$ui['name']])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

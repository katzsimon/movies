{{--
Allows additional columns of information to be displayed for a package/index

Create a file in /resources/views/vendor/katzsimon/admin/PACKAGENAME/_extra_cols.blade.php
With:

@if(!isset($item))
    <!-- Extra Column Header -->
    <th class="text-center">COLUMN TITLE</th>
@else
    <!-- Extra Column Data -->
    <td class="text-center">{{ $item['COLUMN_KEY']??'' }}</td>
@endif

--}}
@if(View::exists("katzsimon::admin.{$ui['items']}._extra_cols"))
    @include("katzsimon::admin.{$ui['items']}._extra_cols")
@endif

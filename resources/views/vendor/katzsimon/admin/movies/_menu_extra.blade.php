{!! Form::open(['url' => route('admin.movies.destroy.screenings', $item['id']), 'method'=>'DELETE']) !!}
<button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap w-full text-left">
    Delete Movie with Screenings
</button>
{!! Form::close() !!}

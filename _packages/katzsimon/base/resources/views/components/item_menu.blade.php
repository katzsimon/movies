<div class="relative inline-block text-left">
    <div>
        <button type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50" id="btn-options-menu{{ $id }}" aria-haspopup="true" aria-expanded="true">

            <!-- Heroicon name: solid/chevron-down -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
            </svg>
        </button>
    </div>

    <div class="origin-top-right absolute right-0 mt-2 rounded-md shadow bg-white ring-1 ring-black ring-opacity-5 z-10 hidden" id="options-menu{{ $id }}">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <a href="{{ isset($parent) ? route("admin.{$parent->getUI()['items']}.{$ui['items']}.edit", [$parent['id'], $item['id']]) : route("admin.{$ui['items']}.edit", $id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap">Edit {{ $name }}</a>
            {!! Form::open(['url' => isset($parent) ? route("admin.".$parent->getUI()['items'].".{$ui['items']}.destroy", [$parent->id, $item['id']]) : route("admin.{$ui['items']}.destroy", $id) , 'method'=>'DELETE']) !!}
            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap w-full text-left">
                Delete {{ $name }}
            </button>
            {!! Form::close() !!}

            @if(View::exists("katzsimon::admin.{$ui['items']}._menu_extra"))
                @include("katzsimon::admin.{$ui['items']}._menu_extra")
            @endif

            @if(isset($extraMenuItems) && count($extraMenuItems)>0)
                @foreach($extraMenuItems as $menuItem)
                    @if(isset($menuItem['method']))
                        {!! Form::open(['url' => $menuItem['href']??'#', 'method'=>$menuItem['method']??'POST']) !!}
                        <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap w-full text-left">
                            {{ $menuItem['text']??'' }}
                        </button>
                        {!! Form::close() !!}
                    @else
                        <a href="{{ $menuItem['href']??'#' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap">{{ $menuItem['text']??'' }}</a>
                    @endif

                @endforeach
            @endif

        </div>
    </div>
    <script type="text/javascript">
        window.addEventListener("DOMContentLoaded", function(event) {
        (function() {
            var btn = document.querySelector("#btn-options-menu{{ $id }}");
            var menu = document.querySelector("#options-menu{{ $id }}");

        	btn.addEventListener('click', function (e) {
                menu.classList.toggle('hidden');
        	});
        }());
        });
    </script>
</div>


    <a href="@if(isset($parent)) {{ route("admin.{$parent->getUI()['items']}.{$item}.create", $parent) }} @else {{ route("admin.{$item}.create") }} @endif" class="text-white bg-blue-600 py-2 px-3 inline-block rounded hover:no-underline hover:bg-blue-700">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="inline">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add <span class="hidden sm:inline">{{ $name??'' }}</span>
    </a>

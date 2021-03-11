<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 shadow">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8" src="/images/logo-white.svg" alt="Logo">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">

                        @if(Auth::check())
                            <a href="{{ route('admin.movies.index') }}" class="btn-nav">Movies</a>
                        @else
                        @endif

                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6  space-x-4">
                    @if(Auth::check())
                        <a href="/admin/dashboard" class="btn-nav">Dashboard</a>
                        <a href="/admin/logout" class="btn-nav">Logout</a>
                    @else
                        <a href="/admin/login" class="btn-nav">Login</a>
                        <a href="/admin/register" class="btn-nav">Register</a>
                    @endif
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" @click="mobileMenuOpen=!mobileMenuOpen">
                    <span class="sr-only">Open main menu</span>
                    <!--
                      Heroicon name: outline/menu

                      Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!--
                      Heroicon name: outline/x

                      Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden" id="mobile-menu"  v-show="mobileMenuOpen">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            @if(Auth::check())
                <a href="{{ route('admin.movies.index') }}" class="btn-nav-mobile">Movies</a>
            @endif
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="mt-3 px-2 space-y-1">
                @if(Auth::check())
                    <a href="/dashboard" class="btn-nav-mobile">Dashboard</a>
                    <a href="/logout" class="btn-nav-mobile">Logout</a>
                @else
                    <a href="/login" class="btn-nav-mobile">Login</a>
                    <a href="/register" class="btn-nav-mobile">Register</a>
                @endif
            </div>
        </div>
    </div>
</nav>

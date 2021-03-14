<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 shadow">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8" src="/images/logo.svg" alt="Logo">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">

                        @if(Auth::check())
                            <a href="{{ route('admin.dashboard') }}" class="btn-nav">Dashboard</a>
                        @else
                        @endif

                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6  space-x-4">
                    @if(Auth::check())
                        <a href="/admin/dashboard" class="text-gray-400 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium hover:no-underline">Dashboard</a>
                        <a href="/admin/logout" class="text-gray-400 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium hover:no-underline">Logout</a>
                    @else
                        <a href="/admin/login" class="text-gray-400 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium hover:no-underline">Login</a>
                        <a href="/admin/register" class="text-gray-400 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium hover:no-underline">Register</a>
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
            <inertia-link :href="$route('admin.dashboard')" class="btn-nav-mobile" :class="isUrl('/admin/dashboard') ? 'bg-gray-900 text-white' : ''" v-if="$page.props.authed">Dashboard</inertia-link>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="mt-3 px-2 space-y-1">
                <inertia-link href="/admin/login" v-if="$page.props.guest" class="btn-nav-mobile">Login</inertia-link>
                <inertia-link href="/admin/register" v-if="$page.props.guest" class="btn-nav-mobile">Register</inertia-link>
                <inertia-link href="/admin/dashboard" v-if="$page.props.authed" class="btn-nav-mobile">Dashboard</inertia-link>
                <inertia-link href="/admin/logout" v-if="$page.props.authed" class="btn-nav-mobile">Logout</inertia-link>
            </div>
        </div>
    </div>
</nav>

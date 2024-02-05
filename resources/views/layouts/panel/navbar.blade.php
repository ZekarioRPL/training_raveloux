<!-- Navbar -->
<nav class="navbar">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="header">
            <div class="navbar-item justify-start">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <i data-feather="menu" width="20px"></i>
                </button>
                <a href="/" class="flex ml-2 md:mr-24">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">CRM</span>
                </a>
            </div>
            <div class="navbar-item">
                <div class="navbar-item ml-3">
                    <div>
                        <button type="button" class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 "
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            @if (auth()->user()->getFirstMediaUrl('user_media'))
                                <img src="{{ auth()->user()->getFirstMediaUrl('user_media') ?? '' }}"
                                    class="w-12 rounded-full h-12">
                            @else
                                <i data-feather="user" class="w-5 h-5" width="20px"></i>
                            @endif
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow "
                        id="dropdown-user">
                        <ul class="py-1" role="none">
                            <li>
                                <a href="{{ Route('profile.edit', auth()->user()->id) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Profile</a>
                            </li>
                            <li>
                                <a href="{{ Route('logout') }}" onclick="return confirm('Anda Yakin Ingin Keluar?')"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign
                                    out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- End Navbar -->

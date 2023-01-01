<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ url('/') }}">
                <img height="50px" src="{{ asset('assets/images/logo/logo2.png') }}" class="header-brand-img desktop-logo"
                    alt="logo">
                <img height="50px" src="{{ asset('assets/images/logo/logo.png') }}"
                    class="header-brand-img toggle-logo" alt="logo">
                <img height="50px" src="{{ asset('assets/images/logo/logo.png') }}"
                    class="header-brand-img light-logo" alt="logo">
                <img height="50px" src="{{ asset('assets/images/logo/logo2.png') }}"
                    class="header-brand-img light-logo1" alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">
                <x-basic-sidebar link="admin/dashboard" text="Dashboard" icon="fe fe-home">
                </x-basic-sidebar>
                @foreach (getMenus() as $menu)
                
                @if ($menu->isseparator)
                    <li class="sub-category">
                        <h3>{{ $menu->name }}</h3>
                    </li>
                @elseif($menu->subMenus->count() == 0)
                    <x-basic-sidebar link="{{ $menu->url }}" text="{{ $menu->name }}"
                        icon="{{ $menu->icon }}">
                    </x-basic-sidebar>
                @else
                    <x-multi-sidebar text="{{ $menu->name }}" icon="{{ $menu->icon }}"
                        link="{{ $menu->url }}">
                        @foreach ($menu->subMenus as $submenu)
                            <x-sub-multi-sidebar link="{{ $submenu->url }}" text="{{ $submenu->name }}">
                            </x-sub-multi-sidebar>
                        @endforeach
                    </x-multi-sidebar>
                @endif
                        
                @endforeach

                {{-- @foreach ($sideMenus as $menu)
                    @if (isset($menu['isseparator']))
                        <li class="sub-category">
                            <h3>{{ $menu['text'] }}</h3>
                        </li>
                    @elseif (isset($menu['multimenu']) && $menu['multimenu'])
                        <x-multi-sidebar text="{{ $menu['text'] }}" icon="{{ $menu['icon'] }}">
                            @foreach ($menu['submenus'] as $submenu)
                                <x-sub-multi-sidebar link="{{ $submenu['link'] }}" text="{{ $submenu['text'] }}">
                                </x-sub-multi-sidebar>
                            @endforeach
                        </x-multi-sidebar>
                    @else
                        <x-basic-sidebar>
                            <x-slot name="link">{{ $menu['link'] }}</x-slot>
                            <x-slot name="icon"><i class="side-menu__icon {{ $menu['icon'] }}"></i></x-slot>
                            <x-slot name="text">{{ $menu['text'] }}</x-slot>
                        </x-basic-sidebar>
                    @endif
                @endforeach --}}

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
    <!--/APP-SIDEBAR-->
</div>

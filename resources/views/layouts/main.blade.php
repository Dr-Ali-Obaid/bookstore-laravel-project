<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {

            font-family: "Cairo", sans-serif;
            background-color: #f0f0f0;
        }

        .bg-cart {
            background-color: #ffc107;
            color: #fff;
        }

        .score {
            display: block;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }

        .score-wrap {
            height: 19px;
            display: inline-block;
            position: relative;
        }

        .score .stars-active {
            color: #ffca00;
            position: relative;
            z-index: 10;
            display: block;
            overflow: hidden;
            white-space: nowrap;
        }

        .score .stars-inactive {
            color: lightgray;
            position: absolute;
            top: 0;
            left: 0;
        }

        .rating {
            overflow: hidden;
            display: inline-block;
            position: relative;
            font-size: 20px;
        }

        .rating-star {
            padding: 0 5px;
            margin: 0;
            cursor: pointer;
            display: block;
            float: left;
        }

        .rating-star::after {
            position: relative;
            font-family: 'Font Awesome 5 Free';
            content: '\f005';
            color: lightgray;
        }

        .rating-star.checked~.rating-star::after,
        .rating-star.checked::after {
            content: '\f005';
            color: #ffca00;
        }

        .rating:hover .rating-star::after {
            content: '\f005';
            color: lightgray;
        }

        .rating-star:hover~.rating-star:after,
        .rating .rating-star:hover:after {
            content: '\f005';
            color: #FFCA00;
        }
    </style>
    @yield('head')
    <title>متجر الكتب</title>
</head>

<body dir="rtl" style="text-align: right">
    <div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('gallery.index') }}">متجر الكتب</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('cart.view') }}" class="nav-link">
                                    @if (Auth::user()->booksInCart()->sum('book_user.number_of_copies') > 0)
                                        <span
                                            class="badge bg-secondary">{{ Auth::user()->booksInCart()->sum('book_user.number_of_copies') }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                    العربة
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            </li>
                        @endauth
                        <li class="nav-item">
                            <a href="{{ route('gallery.categories.index') }}" class="nav-link">التصنيفات
                                <i class="fa-solid fa-list"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('gallery.publishers.index') }}" class="nav-link">الناشرون
                                <i class="fa-solid fa-table"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('gallery.authors.index') }}" class="nav-link ">المؤلفون
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a href="{{route('my.product')}}" class="nav-link">مشترياتي
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </li>
                        @endauth
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        @guest
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">{{ __('تسجيل الدخول') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">{{ __('إنشاء حساب') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown justify-content-left">
                                <a id="navbarDropdown" href="#" class="nav-link" data-bs-toggle="dropdown">
                                    <img class="w-8 h-8 rounded-full object-cover "
                                        src="{{ Auth::user()->profile_photo_path ? Storage::url(Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}">
                                </a>
                                <div class="dropdown-menu dropdown-menu-start px-2 mt-2 text-end">
                                    @can('update-books')
                                        <a href="{{ route('admin.index') }}" class="dropdown-item">لوحة الإدارة</a>
                                    @endcan
                                    <div :class="{ 'block': open, 'hidden': !open }">

                                        <!-- Responsive Settings Options -->
                                        <div class="pt-4 pb-1 border-t border-gray-200">
                                            <div class="flex items-center px-2 ">

                                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}
                                                </div>


                                            </div>

                                            <div class="mt-3  ">
                                                <x-responsive-nav-link href="{{ route('profile.show') }}"
                                                    :active="request()->routeIs('profile.show')">
                                                    {{ __('الملف الشخصي') }}
                                                </x-responsive-nav-link>

                                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}"
                                                        :active="request()->routeIs('api-tokens.index')">
                                                        {{ __('رموز API') }}
                                                    </x-responsive-nav-link>
                                                @endif

                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <x-responsive-nav-link href="#"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('تسجيل الخروج') }}
                                                    </x-responsive-nav-link>
                                                </form>


                                                <!-- Team Management -->
                                                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                                    <div class="border-t border-gray-200"></div>

                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        {{ __('Manage Team') }}
                                                    </div>

                                                    <!-- Team Settings -->
                                                    <x-responsive-nav-link
                                                        href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                                        :active="request()->routeIs('teams.show')">
                                                        {{ __('Team Settings') }}
                                                    </x-responsive-nav-link>

                                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                        <x-responsive-nav-link href="{{ route('teams.create') }}"
                                                            :active="request()->routeIs('teams.create')">
                                                            {{ __('Create New Team') }}
                                                        </x-responsive-nav-link>
                                                    @endcan

                                                    <!-- Team Switcher -->
                                                    @if (Auth::user()->allTeams()->count() > 1)
                                                        <div class="border-t border-gray-200"></div>

                                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                                            {{ __('Switch Teams') }}
                                                        </div>

                                                        @foreach (Auth::user()->allTeams() as $team)
                                                            <x-switchable-team :team="$team"
                                                                component="responsive-nav-link" />
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endguest
                    </ul>

                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>



    <script src="https://kit.fontawesome.com/7a8e9e9dba.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')
</body>

</html>

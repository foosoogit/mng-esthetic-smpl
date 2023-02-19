<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{  asset('/js/MonthlyReport.js') }}" defer></script>
    <!-- Styles -->
    <style>
        input[type=radio] {
            display: none; /* ラジオボタンを非表示にする */
        }
        input[type="radio"]:checked + label {
            background: #31A9EE;/* マウス選択時の背景色を指定する */
            color: #ffffff; /* マウス選択時のフォント色を指定する */
        }
        .label:hover {
            background-color: #E2EDF9; /* マウスオーバー時の背景色を指定する */
        }
        .label {
            display: block; /* ブロックレベル要素化する */
            float: left; /* 要素の左寄せ・回り込を指定する */
            margin: 5px; /* ボックス外側の余白を指定する */
            width: 120px; /* ボックスの横幅を指定する */
            height: 35px; /* ボックスの高さを指定する */
            /*padding-top: -50px;*/
            padding-left: 5px; /* ボックス内左側の余白を指定する */
            padding-right: 5px; /* ボックス内御右側の余白を指定する */
            color: #b20000; /* フォントの色を指定 */
            text-align: center; /* テキストのセンタリングを指定する */
            line-height: 45px; /* 行の高さを指定する */
            cursor: pointer; /* マウスカーソルの形（リンクカーソル）を指定する */
            border: 2px solid #006DD9;/* ボックスの境界線を実線で指定する */
            border-radius: 5px; /* 角丸を指定する */
            /*font-size: larger;*/
            vertical-align:middle;
        }
    </style>
    @livewireStyles
</head>
<body>
    {{--  <livewire:customer-search>--}}
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('staff/login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('staff/register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('staff.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('staff/logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <livewire:monthly-report>
            @yield('content')

        </main>
    </div>
    @livewireScripts
</body>
</html>
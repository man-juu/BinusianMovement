<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiMov</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset ('aset/logo2.png') }}"/>
    <link rel="stylesheet" href="{{ URL::asset('style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-lg" style="background-color: #015581">
        <div class="container-fluid" id="nav-css">
          <a class="navbar-brand" href="/">
            <div class="logo">
                <img src="{{ asset ('aset/logo.png') }}" alt="">
            </div>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 5%">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link nav-link-ltr" href="{{ route('mulaiview', app()->getLocale()) }}">@lang('main.mulai_petisi')</a>
              </li>

            @if (Auth::user())
              <li class="nav-item">
                <a class="nav-link nav-link-ltr" href="{{ route('petisisaya', app()->getLocale()) }}">@lang('main.petisi_saya')</a>
              </li>
            @endif

            @if (!Auth::user() || Auth::user()->role == 'member')
              <li class="nav-item">
                <a class="nav-link nav-link-ltr" href="{{ route('semuapetisi', app()->getLocale()) }}">@lang('main.semua_petisi')</a>
              </li>
            @endif

            @if (Auth::user() && Auth::user()->role == 'admin')
              <li class="nav-item">
                <a class="nav-link nav-link-ltr" href="{{ route('direktori', app()->getLocale()) }}">@lang('main.direktori')</a>
              </li>
            @endif
            </ul>

            {{-- <div class="dropdown" id="ddsty">
              <button class="btn btn-light me-auto mb-2 mb-lg-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ strtoupper(session('locale') ?? config('app.locale')) }}
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route(Route::currentRouteName(), 'en') }}">EN</a></li>
                <li><a class="dropdown-item" href="{{ route(Route::currentRouteName(), 'id') }}">ID</a></li>
              </ul>
            </div> --}}

            <div id="lang-selection">
                <a class="nav-link nav-link-ltr2 active" href="{{ route(Route::currentRouteName(), 'en') }}">EN</a> |
                <a class="nav-link nav-link-ltr2" href="{{ route(Route::currentRouteName(), 'id') }}">ID</a>
            </div>

            @if (Auth::user()==null)
            <a href="{{ route('viewmasuk', app()->getLocale()) }}" style="margin-right: 12px">
                <div id="button-org">@lang('main.masuk')</div>
            </a>
            @else
            <a href="{{ route('logout', app()->getLocale()) }}" style="margin-right: 12px">
                <div id="button-org">@lang('main.keluar')</div>
            </a>
            @endif
          </div>
        </div>
    </nav>

    <div id="content" style="min-height: 100vh">
        @yield('content')
    </div>

    <div id="footer">
        © 2022 Copyright | BiMov.
    </div>

    <script src="{{ URL::asset('script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

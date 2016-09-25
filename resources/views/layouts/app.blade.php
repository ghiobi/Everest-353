<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- FONTS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">

    <link href="{{ elixir('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <script>
        window.Everest = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!}
    </script>

</head>
<body>
<!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <!-- Title -->
                <span class="mdl-layout-title"><a href="/" class="mdl-color-text--grey-200" style="text-decoration: none">{{ config('app.name') }}</a></span>
                <!-- Add spacer, to align navigation to the right -->
                <div class="mdl-layout-spacer"></div>
                <!-- Navigation. We hide it in small screens. -->
                <nav class="mdl-navigation mdl-layout--large-screen-only">
                    @if(Auth::guest())
                        <a class="mdl-navigation__link" href="/login">Login</a>
                        <a class="mdl-navigation__link" href="/register">Register</a>
                    @else
                        <a class="mdl-navigation__link" href="{{ url('/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @endif
                    <!-- Right aligned menu below button -->
                    <button id="demo-menu-lower-right"
                            class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>

                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                        for="demo-menu-lower-right">
                        <li class="mdl-menu__item">Some Action</li>
                        <li class="mdl-menu__item">Another Action</li>
                        <li disabled class="mdl-menu__item">Disabled Action</li>
                        <li class="mdl-menu__item">Yet Another Action</li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">{{ config('app.name') }}</span>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link" href="">Link</a>
                <a class="mdl-navigation__link" href="">Link</a>
                <a class="mdl-navigation__link" href="">Link</a>
                <a class="mdl-navigation__link" href="">Link</a>
            </nav>
        </div>
        <main class="mdl-layout__content">
            <div class="page-content">
                @yield('content')
            </div>
            <footer class="mdl-mega-footer">
                <div class="mdl-mega-footer__middle-section">
                    <div class="mdl-mega-footer__drop-down-section">
                        <h1 class="mdl-mega-footer__heading">Libraries</h1>
                        <ul class="mdl-mega-footer__link-list">
                            <li><a href="https://laravel.com/">Laravel</a></li>
                            <li><a href="https://getmdl.io/">Material Design Lite</a></li>
                            <li><a href="https://design.google.com/icons/">Material Icons</a></li>
                            <li><a href="https://jquery.com/">JQuery</a></li>
                            <li><a href="https://github.com/amsul/pickadate.js">PickaDateJS</a></li>
                        </ul>
                    </div>
                    <div class="mdl-mega-footer__drop-down-section">
                        <h1 class="mdl-mega-footer__heading">Tools</h1>
                        <ul class="mdl-mega-footer__link-list">
                            <li><a href="https://www.npmjs.com/">NPM</a></li>
                            <li><a href="http://gulpjs.com/">Gulp</a></li>
                            <li><a href="https://bower.io/">Bower</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mdl-mega-footer__bottom-section">
                    <div class="mdl-logo">
                        More Information
                    </div>
                    <ul class="mdl-mega-footer__link-list">
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Privacy and Terms</a></li>
                    </ul>
                </div>
            </footer>
        </main>
    </div>

    <script src="{{ elixir('js/vendor.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>

</body>
</html>

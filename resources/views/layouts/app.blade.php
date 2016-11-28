<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="/css/vendor.css" rel="stylesheet">
    <script src="/js/vendor.js"></script>

    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/app.js"></script>

    <script>
        window.Everest = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!}
    </script>

</head>
<body>

    <nav class="navbar navbar-light bg-faded">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/images/logo/logo-hori.png" alt="">
            </a>
            @if(! Auth::guest())
                <form class="form-inline float-xs-left">
                    <input class="form-control" type="text" placeholder="Find a ride.">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            @endif
            <ul class="nav navbar-nav float-xs-right">
                @if(Auth::guest())
                    <li class="nav-item">
                        <span class="navbar-text">Sign in to get started!</span>
                    </li>
                @else
                    <li class="nav-item">
                        <span class="navbar-text text-muted">Balance ${{ Auth::user()->balance() }}</span>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="/user/{{ Auth::user()->id }}"><img src="{{ Auth::user()->avatarUrl(40) }}" class="img-fluid rounded-circle navbar-avatar" alt=""></a>
                        <a class="nav-link dropdown-toggle d-inline-block" id="navbar-dropdown" href="/user/{{ Auth::user()->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->first_name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item" href="/mail">Mail</a>
                            <a class="dropdown-item" href="/post/create">Create Post</a>
                            <a class="dropdown-item" href="/funds">Add Funds</a>
                            <a class="dropdown-item" href="#"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @if(Auth::user()->hasRole('super-admin'))
                                <a href="/setting">System Settings.</a>
                            @endif
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    @yield('content')

    <div class="container text-xs-center copyright">
        All rights reserved | &copy; Copyright {{ date('Y') }} Super | Made with &hearts; by <a href="https://github.com/limphilip">Philip</a> and <a href="http://github.com/ghiobi/">Laurendy</a>
    </div>

    @yield('scripts')

</body>
</html>

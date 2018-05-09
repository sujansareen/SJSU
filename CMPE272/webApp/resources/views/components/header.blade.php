<nav class="navbar navbar-expand-lg navbar-dark bg-dark box-shadow">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', '') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @else
                    <!-- Large View -->
                    <li class="dropdown d-none d-lg-block">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <a class="dropdown-item" href="{{ url('/about') }}">About</a>
                            <a class="dropdown-item" href="{{ url('/services') }}">Services</a>
                            <a class="dropdown-item" href="{{ url('/news') }}">News</a>
                            <a class="dropdown-item" href="{{ url('/contacts') }}">Contacts</a>
                        </div>
                    </li>
                    <!-- Medium and below View -->
                    <div class="d-lg-none">
                        <li><a class="dropdown-item" href="{{ url('/about') }}">About</a></li>
                        <li><a class="dropdown-item" href="{{ url('/services') }}">Services</a></li>
                        <li><a class="dropdown-item" href="{{ url('/news') }}">News</a></li>
                        <li><a class="dropdown-item" href="{{ url('/contacts') }}">Contacts</a></li>
                    </div>
                    <!-- Logout form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
                {{ $slot }}
            </ul>
            {{--<a class="btn btn-outline-info" href="#">Sign up</a>--}}
        </div>
    </div>
</nav>
<script>
    function getCookie(cookieName){
        var cookies = decodeURIComponent(document.cookie).split(';').map(function(item){
                    var x = item.split('=');
                    return {name:x[0].trim(),value:x[1]};
                }) || [];
        return cookies.find(function(item){
            return item.name == cookieName;
        })
    }
    var user = getCookie("user") || {};
    if(!user.value){
        $('#sign-in-li').show();
    } else {
        $('#sign-in-li').show();
        $('#sign-in-li a').text('Users');
    }
</script>
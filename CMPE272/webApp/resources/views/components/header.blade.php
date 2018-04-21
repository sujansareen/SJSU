<nav class="navbar navbar-expand-lg navbar-dark bg-dark box-shadow">
    <a class="navbar-brand" href="/">MyMemories</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/services">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/news">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/contacts">Contacts</a>
            </li>
            <li id="sign-in-li" class="nav-item" style="display: none">
                <a class="nav-link" href="/user">sign in</a>
            </li>
            {{ $slot }}
        </ul>
        {{--<a class="btn btn-outline-info" href="#">Sign up</a>--}}
    </div>
</nav>
<script>

    var user = getCookie("user") || {};
    if(!user.value){
        $('#sign-in-li').show();
    }
</script>
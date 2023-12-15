
@guest
@unless(request()->is('login') || request()->is('register'))
<!-- Navbar for Guests (Login and Register) -->
<nav class="navbar navbar-expand-md navbar-light bg-light d-flex justify-content-center">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        </ul>
    </div>
</nav>
@endunless
@endguest


@auth
<!-- Navbar for Users Logged In -->
<nav class="navbar navbar-expand-md navbar-light bg-light d-flex justify-content-center">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <div class="dropdown">
            <button class="btn bg-gradient-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ auth()->user()->name }}
            </button>
            <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item border-radius-md" href="{{ route('profile.show', ['user' => auth()->user()]) }}">Profile</a></li>
                <li><a class="dropdown-item border-radius-md" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
        
    </div>
</nav>
@endauth
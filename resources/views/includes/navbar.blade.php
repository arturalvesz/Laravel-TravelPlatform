<style>
    #hover-dropdown:hover .dropdown-menu {
        display: block;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 20px;
    }

    .dropdown-menu {
        display: none;
        /* Hide the dropdown by default */
    }

    #hover-dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown-item {
        font-size: 125%;
    }
    .cart-icon {
        width: 20px; /* Set a specific width for the cart icon */
        height: auto; /* Maintain the aspect ratio */
        cursor: pointer;
    }
</style>




@guest
@if(!request()->is('login') || !request()->is('register') || !request()->is('home'))
<!-- Navbar for Guests on Login and Register pages -->
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
@endif
@else
<nav class="navbar navbar-expand-md navbar-light bg-light d-flex justify-content-center">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <div class="d-flex">
            @if(auth()->user()->usertype == 'traveler')
            <button type="button" class="btn btn-link text-success" onclick="document.getElementById('becomeLocalForm').submit()">Become a Local</button>
            <form id="becomeLocalForm" action="{{ route('becomeLocal') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @else
            <a class="btn btn-success" href="{{route('experience.createExperience')}}">Upload Experience</a>
            @endif

            
            <div class="btn" style="background-color:transparent; border-color: transparent;">
            <img src="{{ asset('/defImages/cart.png') }}" class="cart-icon" onclick="location.href='{{ route('cart.show') }}';">
            </div>
            
            <div class="dropdown" id="hover-dropdown">
                <div class="btn" style="background-color:transparent; border-color: transparent;">
                    {{ auth()->user()->name }}
                </div>
                <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="{{ route('profile.show', ['user' => auth()->user()]) }}">Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('orders.index')}}">Orders</a></li>
                    @if(auth()->user()->usertype === 'local')
                    <li><a class="dropdown-item" href="{{ route('orders.sales')}}">Sales</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>
@endguest

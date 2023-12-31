<style>
    #hover-dropdown:hover .dropdown-menu {
        display: block;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
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
        width: 20px;
        /* Set a specific width for the cart icon */
        height: auto;
        /* Maintain the aspect ratio */
        cursor: pointer;
    }
</style>


<nav class="navbar navbar-expand-md navbar-light bg-light d-flex justify-content-center">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            Admin Dashboard
        </a>
        <div class="d-flex">
            <div class="dropdown" id="hover-dropdown">
                <div class="btn" style="background-color:transparent; border-color: transparent;">
                    {{ auth()->user()->name }}
                </div>
                <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">

                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Users</a></li>
                    <li><a class="dropdown-item" href="{{ route('experience.index') }}">Experiences</a></li>
                    <li><a class="dropdown-item" href="{{ route('address.index') }}">Addresses</a></li>
                    <li><a class="dropdown-item" href="{{ route('photo.index') }}">Photos</a></li>
                    <li><a class="dropdown-item" href="{{ route('category.index') }}">Categories</a></li>
                    <li><a class="dropdown-item" href="{{ route('profile.show', ['user' => auth()->user()]) }}">Profile</a></li>
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
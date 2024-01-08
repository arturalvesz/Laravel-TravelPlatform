@extends('layouts.app')

@section('content')

<style>

    body {
        margin: 0;
        padding: 0;
        overflow-y: scroll;
        scrollbar-width: thin;
        scrollbar-color: transparent transparent;
        -ms-overflow-style: none;
    }

    body::-webkit-scrollbar {
        width: 0px;
    }

    body::-webkit-scrollbar-thumb {
        background-color: transparent;
    }

    body::-webkit-scrollbar-track {
        background-color: transparent;
    }

    .navbar {
    width: 100%;
    background-color: transparent;
    z-index: 1000;
    /* Remove fixed positioning */
    position: relative;
    margin-top: -40px; /* Adjust the top margin based on your preference */
}

    #hover-dropdown:hover .dropdown-menu {
        display: block;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 20px;
    }

    .dropdown-menu {
        display: none;
    }

    #hover-dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown-item {
        font-size: 125%;
    }

    .category-container {
        position: relative;
        margin-top: -70px; /* Adjust this margin based on your preference */
    }

    .category-header {
        height: 600px; /* Increase the height of the image */
        width: 100%;
        background-position: center;
        background-size: cover;
        align-items: center;
        justify-content: center; /* Center the content vertically and horizontally */
        display: flex;
        flex-direction: column;
        z-index: -1;
    }

    .nav-tabs {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        text-align: center;
        position: relative;
        top: -50px; /* Adjust the distance of tabs from the center */
    }

    .nav-link.active,
    .nav-link:active,
    .nav-link:hover {
    background-color: #198754 !important;
    color: #fff !important;
}

.nav-link {
    color: #000;
    font-weight: bold;
}
    .experiences-wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 150px; /* Adjust this margin based on your preference */
    }


    .experience-card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        overflow: hidden;
        margin: 10px;
        height: 475px;
        width: 300px;
        outline: none;
        position: relative;
    }

    

    .experience-images-carousel {
        width: 300px;
        height: 450px; /* Increase the height of the images carousel */
        position: relative;
        overflow: hidden;
    }

    .experience-image {
        width: 50px;
        height: 250px;
        object-fit: cover;
    }

    .experience-info {
        padding: 15px;
        text-align: left;
        margin-top: -210px;
    }

    .experience-info p.experience-name {
        font-size: 24px; /* Adjust the font size */
        font-weight: bold;
        text-align: center
    }

    .experience-link {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Inherit text color */
        display: block;
        /* Make the link a block element to fill the container */
        outline: none;
    }
    .checked{
        color:orange;
    }
    a,
a:visited,
a:hover,
a:active,
a:focus {
    outline: none !important;
    text-decoration: none !important;
    color: inherit !important;
}


.experience-price {
        color: #198754;
    }

    .search-bar-container {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Align to the left */
    margin: 20px 0; /* Adjust margin as needed */
}

/* Style for the search input */
.search-bar-container input {
    padding: 6px 10px; /* Adjust padding for a larger input */
    font-size: 14px; /* Adjust font size */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(0, 0, 0, 0.04);
    border-radius: 24px 0 0 24px;
    margin-right: 0;
    width: 250px; /* Adjust the width as needed */
    outline: none;
}

/* Style for the search button */
.search-bar-container button {
    padding: 6px 10px; /* Adjust padding for a larger button */
    font-size: 14px; /* Adjust font size */
    cursor: pointer;
    border-radius: 0 24px 24px 0;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(0, 0, 0, 0.04);
    outline: none;
}


.cart-icon {
        width: 20px; /* Set a specific width for the cart icon */
        height: auto; /* Maintain the aspect ratio */
        cursor: pointer;
    }

.navbar-admin{
    margin-top: -23px;
}

</style>



@guest
<nav class="navbar navbar-expand-md d-flex justify-content-center">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>


        <div class="search-bar-container col md">
            <input type="text" id="searchInput" placeholder="Search experience...">
            <button class="btn btn-success" onclick="searchExperiences()">Search</button>
        </div>


        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link login" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link register" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        </ul>
    </div>
</nav>

@elseif(auth()->user()->usertype == 'admin')

<nav class="navbar navbar-expand-md d-flex justify-content-center navbar-admin">
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
                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">Orders</a></li>
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
@else
<!-- Navbar for authenticated users -->
<nav class="navbar navbar-expand-md d-flex justify-content-center">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>


        <div class="search-bar-container col md">
            <input type="text" id="searchInput" placeholder="Search experience...">
            <button class="btn btn-success" onclick="searchExperiences()">Search</button>
        </div>


        <div class="d-flex">
            @if(auth()->user()->usertype == 'traveler')
            <!-- Button for users with usertype other than 'local' -->
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


<div class="category-container">
    <div class="category-header">
        <div id="imageContainer" style="width: 100%; height: 800px;"></div>
        <ul class="nav nav-tabs" id="experiencesTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true" onclick="changeImage('all')">All Experiences</a>
            </li>
            @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link" id="tab{{ $category->id }}" data-toggle="tab" href="#category{{ $category->id }}" role="tab" aria-controls="category{{ $category->id }}" aria-selected="false" onclick="changeImage('category{{ $category->id }}')">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-12 experiences-wrapper">
        @foreach($experiences as $experience)
        <a href="{{ route('experience.show', $experience) }}" class="experience-link" data-category-id="{{ $experience->category_id }}">

            <div class="experience-card">
                <div class="experience-images-carousel">
                    @forelse($experience->photo as $photo)
                    <div class="experience-image">
                        <img src="{{ asset('storage/images/' . $photo->path) }}" alt="Experience Photo" style="width: 100%; height: 100%;">
                    </div>
                    @empty
                    <div class="experience-image">
                        <img src="{{ asset('/defImages/placeholder.jpg') }}" alt="No Photo" style="width: 100%; height:100%;">
                    </div>
                    @endforelse
                </div>
                <div class="experience-info">
                    <p class="experience-name">{{ $experience->name }}</p>
                    <p class="experience-duration">Duration: {{ $experience->duration }} minutes</p>
                    <p class="experience-location">Location: {{ $experience->location }}</p>
                    <p class="experience-price">Price: {{ $experience->price }}€</p>

                    @if($experience->reviews->isNotEmpty())
                    @php
                    $averageRating = $experience->reviews->first()->average_rating;
                    @endphp
                    <p class="experience-rating">
                    @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $averageRating)
                        <span class="fa fa-star checked"></span>
                    @else
                        <span class="fa fa-star"></span>
                    @endif
                    @endfor
                    </p>
                    @else
                    <p class="experience-rating">No ratings yet.</p>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
    {{ $experiences->links('pagination::bootstrap-5') }}
</div>
</div>

<footer class="py-4 bg-green ">
    <div class="container">
        <p class="m-0 text-center text-white">&copy; 2023 Made in Universidade Fernando Pessoa.</p>
    </div>
</footer>

<style>
    .bg-green {
        background-color: #0e471e; /* Dark Green color */
    }

    footer p {
        margin: 0;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize the carousel for images within each experience
        $('.experience-images-carousel').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: false,
            arrows: false,
        });
    });

    // Load the "All Experiences" image on page load
    window.onload = function() {
        changeImage('all');
    };

    function changeImage(tabId) {
        var imageContainer = document.getElementById('imageContainer');
        var allExperiences = document.querySelectorAll('.experience-link');

        switch (tabId) {
            case 'all':
                imageContainer.innerHTML = '<img src="{{ asset('/defImages/bg1.jpg') }}" alt="All Experiences" style="width: 100%; height: 800px;">';
                showAllExperiences();
                break;
            @foreach($categories as $category)
                case 'category{{ $category->id }}':
                    imageContainer.innerHTML = '<img src="{{ asset('/defImages/bgcat'.$category->name.'.jpg') }}" alt="{{ $category->name }}" style="width: 100%; height: 800px;">';
                    showExperiencesByCategory({{ $category->id }});
                    break;
            @endforeach
            // Add more cases as needed
        }

        updateTabColor(tabId);
    }

    function showAllExperiences() {
        var allExperiences = document.querySelectorAll('.experience-link');
        allExperiences.forEach(function(experience) {
            experience.style.display = 'flex';
        });
    }

    function showExperiencesByCategory(categoryId) {
    var allExperiences = document.querySelectorAll('.experience-link');
    allExperiences.forEach(function(experience) {
        var experienceCategoryId = experience.getAttribute('data-category-id');
        if (experienceCategoryId == categoryId) {
            experience.style.display = 'flex';
        } else {
            experience.style.display = 'none';
        }
    });
}

function updateTabColor(tabId) {
    // Remove the 'active' class from all tabs
    var allTabs = document.querySelectorAll('.nav-link');
    allTabs.forEach(function(tab) {
        tab.classList.remove('active');
    });

    // Add the 'active' class to the clicked tab
    var clickedTab = document.getElementById(tabId);
    clickedTab.classList.add('active');
}


function searchExperiences() {
    var searchInput = document.getElementById('searchInput').value.toLowerCase();
    var activeTab = document.querySelector('.nav-link.active').id; // Get the ID of the active tab

    var allExperiences = document.querySelectorAll('.experience-link');

    allExperiences.forEach(function (experience) {
        var experienceName = experience.querySelector('.experience-name').innerText.toLowerCase();
        var experienceCategoryId = experience.getAttribute('data-category-id');

        if ((activeTab === 'all-tab' && experienceName.includes(searchInput)) ||
            (activeTab === 'tab' + experienceCategoryId && experienceName.includes(searchInput))) {
            experience.style.display = 'flex';
        } else {
            experience.style.display = 'none';
        }
    });
}
</script>

@endsection

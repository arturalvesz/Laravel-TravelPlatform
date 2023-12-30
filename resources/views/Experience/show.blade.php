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

    .category-label {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }

    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        margin-top: 50px;
        /* Adjust margin-top */

        max-width: 900px;
        /* Adjust the max-width as needed */
        margin-left: auto;
        margin-right: auto;
    }

    .experience-header {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .experience-provider {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }

    .experience-description {
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: bold;
    }

    .experience-price {
        font-size: 18px;
        color: #198754;
        /* Adjust the color as needed */
        margin-bottom: 20px;
    }

    .experience-category {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .experience-duration {
        font-size: 18px;
        margin-bottom: -5px;
    }

    .small-phrase {
        font-size: 14px;
        margin-bottom: 15px;
    }

    .photos-slider {
        width: 100%;
        margin-top: 20px;
    }

    .photo {
        width: 100%;
        /* Set width to 100% */
        height: 400px;
        /* Set a fixed height for consistency */
        /* Ensure the image covers the entire container */
        margin-bottom: 10px;
        /* Add some margin between images */
    }

    .category-label {
        margin-top: 40px;
        margin-bottom: -45px;
    }

    .availability-form {
        margin-top: 20px;
    }

    .availability-input {
        margin-bottom: 10px;
    }

    .check-availability-btn {
        margin-top: 20px;
        /* Reduce margin for a smaller button */
        padding: 5px 10px;
        /* Adjust padding for a smaller button */
        font-size: 15px;
        /* Reduce font size */
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="category-label">
                <b>{{ $experience->category->name }}</b>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="experience-header">{{ $experience->name }}</div>
                    <div class="experience-provider">
                        Experience provider: <a href="{{ route('profile.show', $experience->user) }}">{{ $experience->user->name }}</a>
                    </div>
                    <div class="photos-slider">
                        @foreach($experience->photo as $photo)
                        <div>
                            <img src="{{ asset('storage/images/' . $photo->path) }}" alt="{{ $photo->name }}" class="photo">
                        </div>
                        @endforeach
                    </div>
                    <div class="experience-description">{{ $experience->description }}</div>
                    <div class="experience-duration">Duration: {{ $experience->duration }} minutes</div>
                    <div class="small-phrase">Check availability to see starting time</div>
                    <div class="experience-price">Price: {{ $experience->price }}€</div>

                    <div class="text-center">
                        @if(Auth::check() && Auth::user()->id === $experience->user_id)
                        <form action="{{ route('experience.destroy', compact('experience')) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('experience.showAvailability', ['experience' => $experience->id]) }}" class="btn btn-outline-success check-availability-btn">
            Check Availability
        </a>
    </div>

</div>

<script>
    // Initialize Slick Carousel
    $(document).ready(function() {
        $('.photos-slider').slick({
            dots: false,
            infinite: false,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
        });
    });
</script>

@endsection
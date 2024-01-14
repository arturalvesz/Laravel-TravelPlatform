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

    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        margin-top: 50px;
        margin-bottom: 30px;
        max-width: 700px;
        /* Adjust the max-width as needed */
        margin-left: auto;
        margin-right: auto;
    }

    .card-body {
        display: flex;
        flex-direction: row;
        /* Change the direction to horizontal */
        align-items: center;
        text-align: center;
        padding: 20px;
        margin-bottom: -20px;
        /* Add padding for better spacing */
    }

    .rounded-image {
        border-radius: 50%;
        /* Make the image round */
        margin-right: 20px;
        /* Add some space between the image and text */
        width: 150px;
        /* Set the width explicitly */
        height: 150px;
        /* Set the height explicitly */
        object-fit: cover;
        /* Ensure the image covers the entire container */
        margin-bottom: 20px;
    }

    .user-info {
        text-align: left;
        /* Align text to the left */
        flex-grow: 1;
        /* Allow user-info div to grow and take up available space */
    }

    .user-name {
        font-size: 1.5em;
        /* Increase font size for the name */
        font-weight: bold;
        /* Make the name bold */
        margin-bottom: 5px;
        /* Add some space between the name and email */
    }

    .user-email {
        color: #777;
        /* Change color for the email */
        margin-bottom: 20px;
        /* Add more space after the email */
    }

    .btn-edit-profile {
        background-color: #28a745;
        /* Change button color to green */
        border-color: #28a745;
        /* Change button border color to green */
        font-size: 0.8em;
        /* Reduce font size for the button */
        margin-left: auto;
        /* Push the button to the right */
    }


    .experiences-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    @media (max-width: 768px) {
        .experiences-section {
            flex-direction: column;
        }

        .experience-card {
            flex: 0 0 100%;
            /* Full width for smaller screens */
            margin-top: 20px;
            /* Add space between cards for better readability */
        }
    }

    .experience-card {
        margin-top: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 20px;
        flex: 0 0 48%;
        /* Adjust the width as needed for two cards side by side */
        height: 500px;
        width: 400px;
        outline: none;
        margin-left: auto;
        margin-right: auto;
        /* Remove outline on focus */
    }

    .experience-images-carousel {
        width: 100%;
        height: 0;
        padding-bottom: 300px;
        /* Adjust this percentage based on your desired aspect ratio */
        position: relative;
    }

    .experience-image {
        width: 50px;
        height: 250px;
        /* Set the height of the image container */
        object-fit: cover;
    }

    .experience-info {
        padding: 15px;
        text-align: left;
        margin-top: -50px;
        /* Align text to the left */
    }

    .experience-name {
        font-size: 2em;
        /* Increase font size for the name */
        font-weight: bold;
        text-align: center;
        /* Center-align the name */
        margin-bottom: 10px;
    }

    .experience-description {
        font-size: 14px;
        color: #555;
        text-align: left;
        /* Align text to the left */
    }

    *:focus {
        outline: none;
    }

    .experience-link {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Inherit text color */
        display: block;
        /* Make the link a block element to fill the container */
        margin: auto;
        outline: none;
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

    .col-md-10 {
        margin: auto;
        /* Center the column */
    }

    .experience-price {
        color: #198754;
    }

    .no-experiences-message {
        text-align: center;
        font-size: 1.5em;
        font-weight: bold;
        color: #555;
        margin-top: 20px;
    }

    .experiences-available-message {
        text-align: center;
        font-size: 1.5em;
        font-weight: bold;
        color: #555;
        margin-top: 20px;
    }

    
    .fa-star {
       color: #ddd; 
    }

    .fa-star.checked {
        color: #f8ce0b; 
    }

</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if($photo)
                    <img src="{{ asset('storage/images/' . $photo->path) }}" alt="Profile Photo" class="rounded-image img-fluid" width="150" height="150">
                    @else
                    <img src="{{ asset('/defImages/stock.jpg') }}" alt="Default Photo" class="rounded-image mb-4" width="150">
                    @endif
                    <div class="user-info">
                        <p class="user-name">{{ Auth::user()->name }}</p>
                        <p class="user-email">{{ Auth::user()->email }}</p>

                        @php
                        $userExperiencesReviews = collect();
                        foreach ($userExperiences as $experience) {
                        $userExperiencesReviews = $userExperiencesReviews->merge($experience->reviews);
                        }

                        if($userExperiencesReviews->count() > 0) {
                        $averageRating = $userExperiencesReviews->avg('starRating');
                        @endphp

                        <p class="user-rating">
                            Average Rating:
                            @for ($i = 1; $i <= 5; $i++) @if ($i <=$averageRating) <span class="fa fa-star checked"></span>
                                @else
                                <span class="fa fa-star"></span>
                                @endif
                                @endfor
                                ({{ $userExperiencesReviews->count() }} ratings)
                        </p>
                        @php
                        } else {
                        @endphp
                        <p class="user-rating">No ratings yet.</p>
                        @php
                        }
                        @endphp
                    </div>
                    <a href="{{ route('profile.edit', ['user' => $user->id]) }}" class="btn btn-outline-success">Edit Profile</button></a>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="experiences-section">
                @if($userExperiences->isNotEmpty())
                <div class="col-md-12 text-center">
                    <div class="experiences-available-message">Experiences available</div>
                </div>
                @endforelse
                @forelse($userExperiences as $experience)
                <a href="{{ route('experience.show', $experience) }}" class="experience-link">
                    <div class="experience-card">
                        <div class="experience-images-carousel">
                            @forelse($experience->photo as $photo)
                            <div class="experience-image">
                                <img src="{{ asset('storage/images/' . $photo->path) }}" alt="Experience Photo" style="width: 100%; height: 100%;">
                            </div>
                            @empty
                            <!-- Display a default image or a placeholder if there are no photos -->
                            <div class="experience-image">
                                <img src="{{ asset('/defImages/expStock.jpg') }}" alt="No Photo" style="width: 100%; height:100%;">
                            </div>
                            @endforelse
                        </div>
                        <div class="experience-info">
                            <p class="experience-name">{{ $experience->name }}</p>
                            <p class="experience-duration">Duration: {{$experience->duration }} minutes</p>
                            <p class="experience-location">Location: {{$experience->location }}</p>
                            <p class="experience-price">Price: {{ $experience->price }}€</p>
                            
                            @php
                        $userExperiencesReviews = collect();
                        foreach ($userExperiences as $experience) {
                        $userExperiencesReviews = $userExperiencesReviews->merge($experience->reviews);
                        }

                        if($userExperiencesReviews->count() > 0) {
                        $averageRating = $userExperiencesReviews->avg('starRating');
                        @endphp

                        <p class="experience-rating">
                            Average Rating:
                            @for ($i = 1; $i <= 5; $i++) @if ($i <=$averageRating) <span class="fa fa-star checked"></span>
                                @else
                                <span class="fa fa-star"></span>
                                @endif
                                @endfor
                                ({{ $userExperiencesReviews->count() }} ratings)
                        </p>
                        @php
                        } else {
                        @endphp
                        <p class="experience-rating">No ratings yet.</p>
                        @php
                        }
                        @endphp
                        </div>
                    </div>
                </a>

                @empty
                <div class="col-md-12 text-center"> <!-- Adjust the column width if needed -->
                    <div class="no-experiences-message">No experiences found</div>
                </div> @endforelse
            </div>
            <div class="d-flex justify-content-center">
                {{ $userExperiences->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

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
</script>
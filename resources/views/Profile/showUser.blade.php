<style>
    body {
        margin: 0;
        padding: 0;
        
    }

    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 24px;
        margin-top: 50px;
        max-width: 700px; /* Adjust the max-width as needed */
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
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- Remove the card header -->
                <div class="card-body">
                    @if($photo)
                    <img src="{{ asset('storage/images/' . $photo->path) }}" alt="Profile Photo" class="rounded-image img-fluid" width="150" height="150">
                    @else
                    <img src="{{ asset('path/to/default/photo.jpg') }}" alt="Default Photo" class="rounded-image mb-4" width="150">
                    @endif
                    <div class="user-info">
                        <p class="user-name">{{ Auth::user()->name }}</p>
                        <p class="user-email">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-success">Edit Profile</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
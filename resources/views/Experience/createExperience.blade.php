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

    .card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
    }

    .card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control:focus {
        outline-color: #ffffff;
        border-color: #ffffff;
        box-shadow: 0 0 10px #198754;
    }

    .form-select:focus{
        outline-color: #ffffff;
        border-color: #ffffff;
        box-shadow: 0 0 10px #198754;
    }

    .form-control {
        border-radius: 15px;
    }
    .form-select {
        border-radius: 15px;
    }


    .btn-submit {
        margin-top: 10px;
        /* Adjust the margin as needed */
        font-size: 14px;
        /* Adjust the font size as needed */
    }

    .title {
        margin-bottom: 20px;
        /* Adjust the margin as needed */
        margin-top: -10px;
        /* Adjust the margin as needed */
        font-size: 16px;
        /* Adjust the font size as needed */
    }

    .text-secondary {
        font-size: 1.8rem;
        /* Adjust the font size to match the title */
        color: #6c757d;
        /* Adjust the color as needed */
    }

    .schedule-card {
        /* Add styles for the schedule card as needed */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
        margin-bottom: 30px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-body content">
                    <h2 class="text-secondary title">Create an Experience</h2>

                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('experience.storeExperience') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Name" required>
                        </div>

                        <div class="form-group">
                            <textarea name="description" id="description" class="form-control" placeholder="Description" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" placeholder="Price" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" placeholder="Location" required>
                        </div>

                        <div class="form-group">
                        <label for="text">Category:</label>

                            <select name="category_id" id="category_id" class="form-control" placeholder="Categories" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                        <label for="duration">Duration:</label>
                            <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration') }}" placeholder="Duration (in minutes)" required>
                        </div>

                        <div class="form-group">
                            <label for="max_people">Max People:</label>
                            <input type="number" name="max_people" id="max_people" class="form-control" value="{{ old('max_people') }}" placeholder="Maximum Number of People each time" required>
                        </div>

                        <div class="form-group">
                            <label for="images" >Choose Images</label>
                            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                        </div>


                        <!-- Add a schedule card for user-defined timestamps -->
                        <div class="card schedule-card mt-4">
                            <div class="card-body">
                                <h4 class="text-secondary title mb-3">Experience Schedule</h4>

                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="form-group">
                                    <label for="{{ strtolower($day) }}">{{ $day }}:</label>
                                    <input type="text" name="schedule[{{ strtolower($day) }}]" id="{{ strtolower($day) }}" class="form-control" placeholder="Enter timestamps for {{ $day }} (e.g., 10:00, 12:00), leave blank if not open this day ">
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-success">
                            Create Experience
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
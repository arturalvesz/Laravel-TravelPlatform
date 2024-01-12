@extends('layouts.app')

@section('content')

<style>
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

    input,
    select {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
        border: 1px solid #ced4da;
    }

    .btn-submit {
        margin-top: 10px;
        font-size: 14px;
    }

    .title {
        margin-bottom: 20px;
        margin-top: -10px;
        font-size: 16px;
    }

    .text-secondary {
        font-size: 1.8rem;
        color: #6c757d;
    }

    .schedule-card {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
        margin-bottom: 30px;
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


</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body content">
                    <h1 class="text-center mb-3 text-secondary">Experience Create</h1>
                    
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                        <form method="post" action="{{ route('experience.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="">Select a User (Optional)</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Description</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="form-group">
                            <label for="text">Category:</label>

                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">Select a Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text">Price:</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('Price') }}" required>
                            </div>
                            <label for="text">Location:</label>
                            <div class="form-group">
                                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
                            </div>
                            <label for="text">Duration:</label>
                            <div class="form-group">
                                <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration') }}" placeholder="Duration (in minutes)" required>
                            </div>
                            <div class="form-group">
                                <label for="max_people">Max People:</label>
                                <input type="number" name="max_people" id="max_people" class="form-control" value="{{ old('max_people') }}" placeholder="Maximum Number of People each time" required>
                            </div>

                            <div class="form-group">
                                <label for="images">Choose Images:</label>
                                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                            </div>

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

                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-success btn-submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
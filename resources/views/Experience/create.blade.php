@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-danger">Product Create</h1>
            <h2 class="text-secondary text-center">Product Info</h3>
                <form method="post" action="{{ route('experience.store') }}">
                    @csrf
                    <div class="form-group">
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">Select a User (Optional)</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
            <select name="category_id" id="category_id" class="form-select">
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="text">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ old('Price') }}" required>
        </div>
        <label for="text">Location</label>
        <div class="form-group">
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
        </div>
        <div class="form-group">
            <label for="max_people">Max People:</label>
            <input type="number" name="max_people" id="max_people" class="form-control" value="{{ old('max_people') }}" placeholder="Maximum Number of People each time" required>
        </div>

        <div class="form-group">
            <label for="images">Choose Images</label>
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
            <button type="submit" class="btn btn-success">Create</button>
        </div>
        </form>
    </div>
</div>
</div>
@endsection
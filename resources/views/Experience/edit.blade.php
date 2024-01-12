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

</style>

<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-secondary">Experience Edit</h1>
            <h2 class="text-secondary text-center">Experience Info</h2>
            <br>
            <form method="post" action="{{ route('experience.updateExperience',  compact('experience')) }}">
                @csrf
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="{{ $experience->category->id }}">{{ $experience->category->name }}</option>
                        @foreach ($categories as $category)
                        @if($experience->category->id !== $category->id)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $experience->name) }}" >
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $experience->description) }}" >
                </div>

                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" class="form-control" id="duration" name="duration" value="{{ old('duration', $experience->duration) }}" >
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $experience->location) }}" >
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $experience->price) }}" >
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a class="btn btn-success btn-submit" href="/experience">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
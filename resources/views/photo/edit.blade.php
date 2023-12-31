@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-danger">Photo Edit</h1>
            <h2 class="text-secondary text-center">Photo Info</h2>
            <br>
            <form action="{{ route('photo.update', compact('photo')) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <img src="{{ asset('storage/images/' . $photo->path) }}" alt="Profile Photo" class="rounded img-fluid mx-auto d-block" width="160" height="90">
                </div>
                <div class="form-group">
                    <label class="form-label" for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
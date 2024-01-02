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
            <h1 class="text-center mb-5 text-secondary">Photo Show</h1>
            <h2 class="text-secondary text-center">Photo Info</h2>
            <form>
                <div class="form-group">
                    <img src="{{ asset('storage/images/' . $photo->path) }}" alt="Photo" class="rounded img-fluid mx-auto d-block" width="160" height="90">
                </div>
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ old('name', $photo->id) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $photo->name) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="path">Path</label>
                    <input type="text" class="form-control text-cent" id="path" name="path" value="{{ old('name', $photo->path) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="userID">UserID</label>
                    <input type="text" class="form-control" id="userID" name="userID" value="{{ old('name', $photo->user_id) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="ExperienceID">ExperienceID</label>
                    <input type="text" class="form-control text-cent" id="ExperienceID" name="ExperienceID" value="{{ old('name', $photo->experience_id) }}" disabled>
                </div>
                <div class="form-group">
                    <a class="btn btn-success" href="/photos">Go Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
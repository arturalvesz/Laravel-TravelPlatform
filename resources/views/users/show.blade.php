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
            <h1 class="text-center mb-5 text-danger">User Show</h1>
            <h2 class="text-secondary text-center">User Info</h2>
            <form>
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ old('name', $user->id) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control text-cent" id="email" name="email" value="{{ old('name', $user->email) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="usertype">Usertype</label>
                    <input type="text" class="form-control" id="usertype" name="usertype" value="{{ old('name', $user->usertype) }}" disabled>
                </div>

                <div class="form-group">
                    <a class="btn btn-success" href="/users">Go Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
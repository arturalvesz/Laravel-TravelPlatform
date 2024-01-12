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
            <h1 class="text-center mb-5 text-secondary">Category Show</h1>
            <h2 class="text-secondary text-center">Category Info</h2>
            <form>
                <div class="form-group">
                    <label for="name">ID</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->id) }}" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" disabled>
                </div>

                <div class="form-group">
                    <a class="btn btn-success" href="/categories">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
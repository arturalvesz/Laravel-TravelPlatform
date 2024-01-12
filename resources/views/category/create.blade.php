@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-secondary">Category Show</h1>
            <h2 class="text-secondary text-center">Category Info</h3>
                <form method="post" action="{{ route('category.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-success">Create</button>
                        <a class="btn btn-success" href="/categories">Back</a>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
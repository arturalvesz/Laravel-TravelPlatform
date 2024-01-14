@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-secondary">Photo Create</h1>
            <form method="post" action="{{ route('photo.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="experience_id">Select Experience:</label>
                    <select name="experience_id" id="experience_id" class="form-select" required>
                        @foreach ($experiences as $experience)
                            <option value="{{ $experience->id }}">{{ $experience->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" name="image" id="image" required class="form-control">
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a class="btn btn-success" href="/photos">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

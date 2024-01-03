@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center mb-5 text-secondary">Review</h1>

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <form method="post" action="{{ route('review.store') }}">
                @csrf
                <div class="form-group">
                    <input type="hidden" id="order_experience_id" name="order_experience_id" value="{{$order_experience->id}}" />
                    <h4>Creating a review for {{ $experience->name }}</h4>
                    <span>Your rating</span>
                    <input type="number" class="form-control" id="starRating" name="starRating" max="5">

                    <label for="comment">Comment</label>
                    <input type="text" class="form-control" id="comment" name="comment">
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-outline-success">Submit</button>
                </div>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

@endsection
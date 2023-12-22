@extends('layouts.app')
@section('content')
    @if(auth()->user()->id == $user->id)
    @include('profile.showUser')
    @else
    @include('profile.showOther')
    @endif
@endsection
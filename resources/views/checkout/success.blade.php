@extends('layouts.app')
@section('content')
<div class="mt-5 card">
    <div style="align-items: center; justify-content:center;">
        <h1 class="text-center">Thanks for your order!</h1><br>
        <h2 class="text-center">Thanks for reserving with <b>LocalsGather</b>, {{ Auth::user()->name }}!</h2>
    </div>
</div>
@endsection
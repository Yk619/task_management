@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h3>Welcome, {{ auth()->user()->name }}!</h3>
            <p>Role: {{ auth()->user()->role }}</p>
            <p>Use the left menu to navigate.</p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tasks</h5>
        </div>
        <div class="card-body">
            @livewire('tasks.tasks')
        </div>
    </div>
</div>
@endsection

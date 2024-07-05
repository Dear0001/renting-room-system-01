@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-blue-200 p-3 rounded">Floor Details</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><strong>Floor Name:</strong> {{ $floor->floor_name }}</h5>
                <p class="card-text"><strong>Description:</strong> {{ $floor->floor_description }}</p>
            </div>
        </div>

        <a href="{{ route('floors.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection

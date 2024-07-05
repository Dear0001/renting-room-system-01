@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-blue-200 p-3 rounded">Room Details</h1>

        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    @if($room->image)
                        <img src="{{ asset($room->image) }}" class="card-img" alt="Room Image">
                    @else
                        <img src="https://via.placeholder.com/400" class="card-img" alt="Room Image">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Room Number:</strong> {{ $room->room_number }}</h5>
                        <p class="card-text"><strong>Description:</strong> {{ $room->room_description }}</p>
                        <p class="card-text"><strong>Floor:</strong> {{ $room->floor->floor_name }}</p>
                        <p class="card-text"><strong>Category:</strong> {{ $room->category->name }}</p>
                        <p class="card-text"><strong>Availability:</strong> {{ $room->is_available ? 'Available' : 'Not Available' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('rooms.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection

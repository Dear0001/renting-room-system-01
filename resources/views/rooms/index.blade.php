@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-blue-200 p-3 rounded">Rooms</h1>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">Create Room</a>

        <div class="row">
            @foreach ($rooms as $room)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($room->image)
                            <img src="{{ asset($room->image) }}" class="card-img-top" alt="Room Image" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/400" class="card-img-top" alt="Room Image" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $room->room_number }}</h5>
                            <p class="card-text">{{ Str::limit($room->room_description, 100) }}</p>
                            <p class="card-text"><strong>Floor:</strong> {{ $room->floor->floor_name }}</p>
                            <p class="card-text"><strong>Category:</strong> {{ $room->category->name }}</p>
                            <p class="card-text"><strong>Availability:</strong> {{ $room->is_available ? 'Available' : 'Not Available' }}</p>
                            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $rooms->links() }}
    </div>
@endsection

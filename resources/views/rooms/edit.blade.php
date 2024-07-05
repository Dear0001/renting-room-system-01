@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Room</h1>
        <form action="{{ route('rooms.update', $room->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="room_number">Room Number</label>
                <input type="text" name="room_number" id="room_number" class="form-control" value="{{ $room->room_number }}" required>
            </div>
            <div class="form-group">
                <label for="room_description">Description</label>
                <textarea name="room_description" id="room_description" class="form-control">{{ $room->room_description }}</textarea>
            </div>
            <div class="form-group">
                <label for="floor_id">Floor</label>
                <select name="floor_id" id="floor_id" class="form-control" required>
                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}" {{ $room->floor_id == $floor->id ? 'selected' : '' }}>{{ $floor->floor_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $room->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Room</button>
        </form>
    </div>
@endsection

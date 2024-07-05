@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-red-200">Create Room</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="room_number">Room Number</label>
                <input type="text" name="room_number" id="room_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="room_description">Description</label>
                <textarea name="room_description" id="room_description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="floor_id">Floor</label>
                <select name="floor_id" id="floor_id" class="form-control" required>
                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}">{{ $floor->floor_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Room Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="is_available">Is Available</label>
                <input type="checkbox" name="is_available" id="is_available" value="1" class="form-check-input">
            </div>
            <button type="submit" class="btn btn-primary">Create Room</button>
        </form>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Floor</h1>
        <form action="{{ route('floors.update', $floor->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="floor_name">Floor Name</label>
                <input type="text" name="floor_name" id="floor_name" class="form-control" value="{{ $floor->floor_name }}" required>
            </div>
            <div class="form-group">
                <label for="floor_description">Description</label>
                <textarea name="floor_description" id="floor_description" class="form-control">{{ $floor->floor_description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Floor</button>
        </form>
    </div>
@endsection

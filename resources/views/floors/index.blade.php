@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Floors</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('floors.create') }}" class="btn btn-primary mb-3">Create Floor</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Floor Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($floors as $floor)
                <tr>
                    <td>{{ $floor->id }}</td>
                    <td>{{ $floor->floor_name }}</td>
                    <td>{{ $floor->floor_description }}</td>
                    <td>
                        <a href="{{ route('floors.show', $floor->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('floors.edit', $floor->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('floors.destroy', $floor->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

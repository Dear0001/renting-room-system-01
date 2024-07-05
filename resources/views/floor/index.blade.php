@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-blue-200 p-3 rounded">Floors</h1>
        <a href="{{ route('floors.create') }}" class="btn btn-primary mb-3">Create Floor</a>

        <div class="row">
            @foreach ($floors as $floor)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $floor->floor_name }}</h5>
                            <p class="card-text">{{ Str::limit($floor->floor_description, 100) }}</p>
                            <a href="{{ route('floors.show', $floor->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('floors.edit', $floor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('floors.destroy', $floor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $floors->links() }}
    </div>
@endsection

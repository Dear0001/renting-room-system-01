@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-red-200">Create Floor</h1>

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

        <form action="{{ route('floors.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="floor_name">Floor Name</label>
                <input type="text" name="floor_name" id="floor_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="floor_description">Description</label>
                <textarea name="floor_description" id="floor_description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Floor</button>
        </form>
    </div>
@endsection

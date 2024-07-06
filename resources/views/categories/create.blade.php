@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-red-200">Create Category</h1>

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

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" id="category_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category_description">Description</label>
                <textarea name="category_description" id="category_description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Category</button>
        </form>
    </div>
@endsection

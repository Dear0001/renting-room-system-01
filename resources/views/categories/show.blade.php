@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="bg-blue-200 p-3 rounded">Category Details</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><strong>Category Name:</strong> {{ $category->category_name }}</h5>
                <p class="card-text"><strong>Description:</strong> {{ $category->category_description }}</p>
            </div>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection

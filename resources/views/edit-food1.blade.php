@extends('layouts.app')

@section('title', 'Edit Food Category')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Edit Food Category</h1>

    <!-- Display any errors or success messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('foods.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $food->food_id }}">

        <div class="form-group">
            <label for="description">Food Description:</label>
            <input type="text" name="Descriptions" id="description" class="form-control" value="{{ old('Descriptions', $food->Descriptions) }}" required>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ url('category-foods-desserts') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </form>
</div>
@endsection

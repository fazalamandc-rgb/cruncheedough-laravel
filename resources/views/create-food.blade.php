<!-- resources/views/create-food.blade.php -->

@extends('layouts.app')

@section('title', 'Add New Food Category')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Add a New Food Category</h1>

    <form action="{{ route('foods.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="Descriptions">Category Description</label>
            <input type="text" class="form-control" id="Descriptions" name="Descriptions" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Add Category</button>
        <a href="{{ route('foods.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection

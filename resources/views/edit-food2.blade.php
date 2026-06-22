@extends('layouts.app')

@section('title', 'Edit Sub-Category Food/Dessert')

@section('content')
<div class="container mt-5">
    <h1>Edit Sub-Category</h1>

    <form action="{{ route('subFoods.update', ['id' => $food->fsub_categ_id]) }}" method="POST">
        
        @csrf
        <input type="hidden" name="id" value="{{ $food->fsub_categ_id }}">
        @method('PUT')
    
        <div class="form-group">
            <label for="fs_descriptions">Description</label>
            <input type="text" class="form-control" id="fs_descriptions" name="fs_descriptions" value="{{ old('fs_descriptions', $food->fs_descriptions) }}" required>
        </div>
    
        <div class="form-group">
            <label for="food_id">Category ID</label>
            <input type="number" class="form-control" id="food_id" name="food_id" value="{{ old('food_id', $food->food_id) }}" required>
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
    

    <a href="{{ route('subFoods.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Create New Food Item')

@section('content')
<div class="container mt-5">
    <h1>Create New Food Item</h1>

    <form action="{{ route('foodItems.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="item_description">Description</label>
            <input type="text" class="form-control" id="item_description" name="item_description" value="{{ old('item_description') }}" required>
        </div>

        <div class="form-group">
            <label for="unit_price">Unit Price</label>
            <input type="text" class="form-control" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" required>
        </div>

        <div class="form-group">
            <label for="fsub_categ_id">Sub-Category ID</label>
            <input type="number" class="form-control" id="fsub_categ_id" name="fsub_categ_id" value="{{ old('fsub_categ_id') }}" required>
        </div>

        <div class="form-group">
            <label for="food_id">Category ID</label>
            <input type="number" class="form-control" id="food_id" name="food_id" value="{{ old('food_id') }}" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>

    <a href="{{ route('foodItems.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection

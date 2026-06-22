@extends('layouts.app')

@section('title', 'Edit Food Item')

@section('content')
<div class="container mt-5">
    <h1>Edit Food Item</h1>

    <form action="{{ route('foodItems.update', ['id' => $foodItem->fitem_id]) }}" method="POST">
        
        @csrf
        <input type="hidden" name="id" value="{{ $foodItem->fitem_id }}">
        @method('PUT')
    
        <div class="form-group">
            <label for="item_description">Description</label>
            <input type="text" class="form-control" id="item_description" name="item_description" value="{{ old('item_description', $foodItem->item_description) }}" required>
        </div>
    
        <div class="form-group">
            <label for="unit_price">Unit Price</label>
            <input type="text" class="form-control" id="unit_price" name="unit_price" value="{{ old('unit_price', $foodItem->unit_price) }}" required>
        </div>
    
        <div class="form-group">
            <label for="fsub_categ_id">Sub-Category ID</label>
            <input type="number" class="form-control" id="fsub_categ_id" name="fsub_categ_id" value="{{ old('fsub_categ_id', $foodItem->fsub_categ_id) }}" required>
        </div>
    
        <div class="form-group">
            <label for="food_id">Category ID</label>
            <input type="number" class="form-control" id="food_id" name="food_id" value="{{ old('food_id', $foodItem->food_id) }}" required>
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>

    <a href="{{ route('foodItems.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection

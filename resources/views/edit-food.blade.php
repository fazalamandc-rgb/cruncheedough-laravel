@extends('layouts.app')

@section('title', 'Edit Food Category')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Edit Food Category</h1>

    <form action="{{ route('foods.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $food->food_id }}">

        <div class="form-group">
            <label for="Descriptions">Food Description</label>
            <input type="text" name="Descriptions" id="Descriptions" class="form-control"
                   value="{{ old('Descriptions', $food->Descriptions) }}" required>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="{{ url('fc_view') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

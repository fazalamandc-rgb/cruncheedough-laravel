@extends('layouts.app')

@section('title', 'Category Foods/Desserts')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Category Foods/Desserts</h1>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
            <tr>
                <td>{{ $food->food_id }}</td>
                <td>{{ $food->Descriptions }}</td>
                
                <td>
                    <a href="{{ route('foods.edit', ['id' => $food->food_id]) }}" class="btn btn-primary btn-sm">Edit</a>

                    <!-- Delete Button (Hyperlink style) -->
                    <a href="{{ route('foods.delete', $food->food_id) }}" class="btn btn-danger btn-sm" 
                        onclick="event.preventDefault(); 
                                 if(confirm('Are you sure you want to delete this food category?')) {
                                     document.getElementById('delete-form-{{ $food->food_id }}').submit();
                                 }">
                        Delete
                    </a>

                    <!-- Hidden Form for Delete -->
                    <form id="delete-form-{{ $food->food_id }}" action="{{ route('foods.delete', $food->food_id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <!-- This will link to the form where users can add a new food category -->
        <a href="{{ route('foods.create') }}" class="btn btn-success">Add a New Record</a>
        <a href="{{ url('mainadm') }}" class="btn btn-secondary">Back to Catalog</a>
    </div>
</div>
@endsection

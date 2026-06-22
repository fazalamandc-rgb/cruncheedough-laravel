@extends('layouts.app')

@section('title', 'Sub-Category Foods/Desserts')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Sub-Category Foods/Desserts</h1>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Category ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
            <tr>
                <td>{{ $food->fsub_categ_id }}</td>
                <td>{{ $food->fs_descriptions }}</td>
                <td>{{ $food->food_id }}</td>
                <td>
                    <!-- Edit Button -->
              
                    <a href="{{ route('subFoods.edit', ['id' => $food->fsub_categ_id]) }}" class="btn btn-primary btn-sm">Edit</a>
                    
                    <!-- Delete Button (Hyperlink style) -->
                    <a href="{{ route('subFoods.delete', $food->fsub_categ_id) }}" class="btn btn-danger btn-sm" 
                        onclick="event.preventDefault(); 
                                 if(confirm('Are you sure you want to delete this sub-category?')) {
                                     document.getElementById('delete-form-{{ $food->fsub_categ_id }}').submit();
                                 }">
                        Delete
                    </a>

                    <!-- Hidden Form for Delete -->
                    <form id="delete-form-{{ $food->fsub_categ_id }}" action="{{ route('subFoods.delete', $food->fsub_categ_id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <!-- Add New Record Button -->
        <a href="{{ route('subFoods.create') }}" class="btn btn-success">Add a New Record</a>
        <a href="{{ url('mainadm') }}" class="btn btn-secondary">Back to Catalog</a>
    </div>
</div>
@endsection

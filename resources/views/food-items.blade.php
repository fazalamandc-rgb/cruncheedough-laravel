@extends('layouts.app')

@section('title', 'Food Items')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Food Items</h1>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Unit Price</th>
                <th>Sub-Category ID</th>
                <th>Category ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foodItems as $item)
            <tr>
                <td>{{ $item->fitem_id }}</td>
                <td>{{ $item->item_description }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->fsub_categ_id }}</td>
                <td>{{ $item->food_id }}</td>
                <td>
                    <!-- Edit Button -->
                    <a href="{{ route('foodItems.edit', ['id' => $item->fitem_id]) }}" class="btn btn-primary btn-sm">Edit</a>
                    
                    <!-- Delete Button -->
                    <a href="{{ route('foodItems.destroy', $item->fitem_id) }}" class="btn btn-danger btn-sm" 
                        onclick="event.preventDefault(); 
                                 if(confirm('Are you sure you want to delete this item?')) {
                                     document.getElementById('delete-form-{{ $item->fitem_id }}').submit();
                                 }">
                        Delete
                    </a>

                    <!-- Hidden Form for Delete -->
                    <form id="delete-form-{{ $item->fitem_id }}" action="{{ route('foodItems.destroy', $item->fitem_id) }}" method="POST" style="display: none;">
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
        <a href="{{ route('foodItems.create') }}" class="btn btn-success">Add a New Item</a>
        <a href="{{ url('mainadm') }}" class="btn btn-secondary">Back to Catalog</a>
    </div>
</div>
@endsection

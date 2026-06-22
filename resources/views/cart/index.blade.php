@extends('layouts.app')

@section('content')
<div class="container mt-4" style="background-color: inherit; padding: 20px;">
    <h1 class="mb-4">Your Cart</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
           
        </div>
    @endif

    @if($cartItems && count($cartItems) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 30%;">Description</th>
<th style="width: 10%;">Unit Price</th>
<th style="width: 20%;">Category</th>
<th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->ds }}</td>
                            <td>£{{ number_format((float) preg_replace('/[^\d\.]/', '', $item->up), 2, '.', '') }}</td>
                            <td>{{ $item->fscds }}</td>
                            
                            <td>
                                <form action="{{ route('cart.remove', $item->itm) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h3>Total: <strong>£{{ number_format((float) $totalAmount, 2, '.', '') }}</strong></h3>
            <a href="{{ route('loginb', ['redirect_url' => route('cart.view')]) }}" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    @else
        <div class="alert alert-info mt-4">
            <p>Your cart is empty. <a href="{{ route('loginb', ['redirect_url' => route('cart.view')]) }}" class="text-decoration-underline">Start shopping now</a>.</p>
        </div>
    @endif
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Counter</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- Display message if provided -->
    <h1>{{ $message ?? 'Kitchen Counter' }}</h1>

    <!-- Success message if order is updated -->
    @if(session('success'))
        <div style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Details</th>
                <th>Delivery Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($output as $order)
                <tr>
                    <td>{{ $order['order_id'] }}</td>
                    <td>{{ $order['customer_name'] }}</td>

                    <td>
                        <ul>
                            @foreach ($order['order_details'] as $detail)
                                <li>{{ $detail->item_description }} ({{ $detail->fs_descriptions }}): {{ $detail->unit_price }}</li>
                            @endforeach
                    
                            
                            <strong>Total Amount:</strong> £{{ number_format($order['total_amount'], 2) }}<br>
                        </ul>
                    </td>

                    <!-- Update Form for Delivery Status -->
                    <td>
                        <form action="{{ route('kitchen.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order['order_id'] }}">

                            <!-- Delivery status options -->
                            <label for="delivered_yes">Yes</label>
                            <input type="radio" id="delivered_yes" name="delivered" value="1" 
                                {{ old('delivered', $order['delivered'] ?? 0) == 1 ? 'checked' : '' }} required>

                            <label for="delivered_no">No</label>
                            <input type="radio" id="delivered_no" name="delivered" value="0" 
                                {{ old('delivered', $order['delivered'] ?? 0) == 0 ? 'checked' : '' }} required>

                            <br><br><button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('mainadm') }}" class="btn btn-secondary">Back to Catalog</a>

</body>
</html>

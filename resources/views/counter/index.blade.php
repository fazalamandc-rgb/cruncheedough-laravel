<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Page</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- Display message if provided -->
    <h1>{{ $message ?? 'Counter Disk' }}</h1>

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
                <th>Payment Status</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($output as $order)
                <tr>
                    <td>{{ $order['order_id'] }}</td>
                    <td>{{ $order['customer_name'] }} / {{ $order['customer_email'] }}</td>
                    <td>
                        <ul>
                            @foreach ($order['order_details'] as $detail)
                                <li>{{ $detail->item_description }} ({{ $detail->fs_descriptions }}): {{ $detail->unit_price }}</li>
                            @endforeach
                            <strong>Total Amount:</strong> £{{ number_format($order['total_amount'], 2) }}<br>
                            <strong>Payment Status:</strong> 
                            @if ($order['payment'] == 1)
                                Paid
                            @else
                                Not Paid
                            @endif
                        </ul>
                    </td>

                    <!-- Update Form for Payment -->
                    <td>
                        <form action="{{ route('counter.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order['order_id'] }}">
                        
                            <label for="payment_yes">Yes</label>
                            <input type="radio" id="payment_yes" name="payment" value="1" 
                                {{ old('payment', $order['payment'] ?? 0) == 1 ? 'checked' : '' }} required>

                            <label for="payment_no">No</label>
                            <input type="radio" id="payment_no" name="payment" value="0" 
                                {{ old('payment', $order['payment'] ?? 0) == 0 ? 'checked' : '' }} required>
                            
                            <br><br><button type="submit">Update</button>
                        </form>

                        <!-- Email Button: Only show if payment is received -->
                        @if ($order['payment'] == 1)
                            <form action="{{ route('counter.sendEmail') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order['order_id'] }}">
                                <input type="hidden" name="customer_email" value="{{ $order['customer_email'] }}">
                                <input type="hidden" name="total_amount" value="{{ $order['total_amount'] }}">
                                <button type="submit">Send Email</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('mainadm') }}" class="btn btn-secondary">Back to Catalog</a>

</body>
</html>

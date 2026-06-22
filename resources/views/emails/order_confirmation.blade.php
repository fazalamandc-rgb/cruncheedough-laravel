<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Thank You for Your Order!</h2>
    <p><strong>Order ID:</strong> {{ $order['id'] }}</p>
    <p><strong>Customer Name:</strong> {{ $order['customer_name'] }}</p>
    <p><strong>Total Amount:</strong> ${{ $order['total'] }}</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            font-size: 20px;
            color: #8B0000;
            margin-bottom: 20px;
        }

        .total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }

        .customer-info p {
            margin: 5px 0;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>CRUNCHEEDOUGH Receipt Slip</h2>
        <p>Date: {{ $currentDate }}</p>
    </div>

    <div class="customer-info">
        <p><strong>Customer:</strong> {{ $customer->customer_name }}</p>
        <p><strong>Email/Cell:</strong> {{ $customer->customer_id }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order as $item)
                <tr>
                    <td>{{ $item->fs_descriptions }}: {{ $item->item_description }}</td>
                    <td>£{{ number_format((float)str_replace('£', '', $item->unit_price), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total Price: £{{ number_format((float)str_replace('£', '', $totalAmount), 2) }}</p>

</body>

</html>

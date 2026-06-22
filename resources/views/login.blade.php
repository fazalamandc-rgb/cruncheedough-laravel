<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        #cartContainer {
            display: inline-block;
            position: relative;
        }
        #cartItemCount {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            border: 2px solid white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }
        .note {
            color: #FF0000;
            font-size: 15px;
            margin-top: 20px;
        }
        /* Adjust table column widths and text wrapping */
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
        table th {
            word-wrap: break-word;
        }
        table td {
            word-break: break-word;
            white-space: normal;
        }
        table th:nth-child(1),
        table td:nth-child(1) {
            width: 10%; /* Select column */
        }
        table th:nth-child(2),
        table td:nth-child(2) {
            width: 50%; /* Description column */
        }
        table th:nth-child(3),
        table td:nth-child(3) {
            width: 20%; /* Price column */
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center text-primary" style="font-size: 30px;">
            CRUNCHEEDOUGH <br><br>
            <a href="{{ route('cart.view') }}">

            <div id="cartContainer" style="display: inline-block; position: relative;">
                <img src="{{ asset('img/c4.png') }}" alt="Cart" id="cartIcon" style="width: 50px; height: 50px;">
                <sup id="cartItemCount" style="
                    position: absolute;
                    top: -10px;
                    right: -10px;
                    background: red;
                    color: white;
                    border-radius: 50%;
                    padding: 5px 10px;
                    font-size: 14px;
                    font-weight: bold;
                    border: 2px solid white;
                    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
                ">
                    {{ $cart_count ?? 0 }}
                </sup>
            </div>
        </a>
        </h3>

        <form id="insert_form">
            @csrf
            <div class="table-responsive text-center text-maroon" style="font-size: 15px;">
                <table class="table table-bordered">
                    <tr><td>Order No:</td><td>{{ $order_no ?? 'N/A' }}</td></tr>
                    <tr><td>Customer Name:</td><td>{{ $user_name ?? 'N/A' }}</td></tr>
                    <tr><td>ID (Email/Cell):</td><td>{{ $cid ?? 'N/A' }}</td></tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="item_table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Choices</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="food_disserts[]" class="form-control food_disserts" id="food_disserts1" data-food_disserts_id="1">
                                    <option value="">Select Choice</option>
                                    @foreach($food_categ as $item)
                                        <option value="{{ $item->food_id }}">{{ $item->Descriptions }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="fsc[]" class="form-control fsc" id="fsc1" data-fsc_id="1">
                                    <option value="">Available Options</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div id="showdet" class="text-center"></div>
                <div class="row" id="show_info" class="text-center"></div>

                <div class="text-center">
                    <input type="submit" name="submit" class="btn btn-info" value="Add to Cart">
                    <button type="button" name="award" class="btn btn-success btn-xs award">Print Bill</button>
                    <br><br>
                    <p class="note">
                        Note: If you are allergic to anything we serve, please let a member of CRUNCHEEDOUGH’s staff know when ordering. Thank you.
                    </p>
                    <a href="{{ route('exit') }}" class="btn btn-danger">Exit</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Handle dropdown change for food_disserts
            $(document).on('change', '.food_disserts', function() {
                var foodId = $(this).val();  // Get the selected food category ID
    
                if (foodId) {
                    // Make an AJAX request to the controller
                    $.ajax({
                        url: '/foodsubcateg/' + foodId,
                        method: 'GET',
                        success: function(response) {
                            // Fill the second dropdown (fsc) with the response (options)
                            $('#fsc1').html(response);
                        },
                        error: function() {
                            alert('Failed to load options');
                        }
                    });
                } else {
                    // Clear the fsc dropdown if no food category is selected
                    $('#fsc1').html('<option value="">Available Options</option>');
                }
            });
    
            // Handle dropdown change for fsc
            $(document).on('change', '.fsc', function() {
                var fscId = $(this).val();  // Get the selected fsc_id
                var foodId = $('#food_disserts1').val();  // Get the selected food category ID

                if (fscId && foodId) {
                    // Make an AJAX request to fetch the relevant food items
                    $.ajax({
                        url: '/get-food-items',
                        method: 'GET',
                        data: { fsc_id: fscId, food_id: foodId },
                        success: function(response) {
                            // Start building the table HTML
                            var itemsHTML = '<table class="table table-bordered table-striped">';
                            itemsHTML += '<thead><tr><th>Select</th><th>Description</th><th>Price</th></tr></thead>';
                            itemsHTML += '<tbody>';
                            
                            // Loop through the food items and format them in table rows
                            $.each(response, function(index, item) {
                                itemsHTML += '<tr>';
                                
                                itemsHTML += '<td><input type="checkbox" name="food_items[]" value="' +  item.fitem_id  + '" class="food-item-checkbox"></td>';

                                itemsHTML += '<td>' + item.item_description + '</td>';
                                itemsHTML += '<td>' + item.unit_price + '</td>';
                                itemsHTML += '</tr>';
                            });

                            itemsHTML += '</tbody></table>';  // Close the table

                            // Insert the table HTML into the show_info div
                            $('#show_info').html(itemsHTML);
                        },
                        error: function() {
                            alert('Failed to load food items');
                        }
                    });
                } else {
                    $('#show_info').html('');  // Clear the food items if no valid selection is made
                }
            });




//here


    $(document).ready(function () {
        $('.award').click(function () {
            // Get the customer ID and order number (ensure these are available)
            let customerId = '{{ session('cid') }}';  // Assuming `cid` is stored in the session
            let orderId = '{{ session('order_no') }}';  // Assuming `order_no` is stored in the session

            // If `customerId` and `orderId` are available in your session or data attributes, use them.
            if (customerId && orderId) {
                // Open the PDF generation URL in a new tab
                 window.open(`/generate-pdf?cid=${customerId}&order_no=${orderId}`, '_blank');  
               //or this one using route name instead of actual path, both are working
              // const generatePdfUrl = "{{ route('generate.pdf') }}";
             //  window.open(`${generatePdfUrl}?cid=${customerId}&order_no=${orderId}`, '_blank');

                
            } else {
                alert('Customer ID or Order ID is missing.');
            }
        });
    });


//tohere


            // Handle form submission via AJAX
            $('#insert_form').off('submit').on('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        // Get form data
        var formData = $(this).serialize(); // Serialize the form data
        console.log('Form Data:', formData); // Log the serialized form data to the console

        // Send data via AJAX
        $.ajax({
            url: '{{ route('addToCart') }}', // Route to controller method
            method: 'POST',
            data: formData,
            success: function (response) {
                // Log the server's response to the console
                console.log('Server Response:', response);

                // Update cart count
                $('#cartItemCount').text(response.cartCount);
                alert('Item added to cart!');
                $('input[name="food_items[]"]').prop('checked', false); // Uncheck all checkboxes
            },
            error: function (xhr, status, error) {
                // Log the error details to the console
                console.error('Error:', error);
                console.error('Response:', xhr.responseText);
                alert('Failed to add item to cart');
            }
        });
    });
        });
    </script>
</body>
</html>

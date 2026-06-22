<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    // Method to generate the PDF
    public function generatePdf(Request $request)
    {
        // Get customer ID and order ID from query parameters
        $customerId = $request->input('cid');
        $orderId = $request->input('order_no');

        // Fetch customer data and order details from the database
    $customer = DB::table('customers')->where('customer_id', $customerId)->first();
    $order = DB::table('orders')
    ->join('food_item', 'orders.fitem_id', '=', 'food_item.fitem_id')
    ->join('food_sub_categ', function ($join) {
        $join->on('orders.food_id', '=', 'food_sub_categ.food_id')
             ->on('orders.fsub_categ_id', '=', 'food_sub_categ.fsub_categ_id'); // Second join condition
    })
    ->where('orders.custormer_id', $customerId)
    ->where('orders.order_id', $orderId)
    ->whereDate('orders.order_date', now()->toDateString())
    ->select(
        'food_item.item_description',
        'food_item.unit_price',
        'food_sub_categ.fs_descriptions',
        'orders.qr_code as qr'
    )
    ->get();
        // Calculate total amount for the order
        $totalAmount = 0;
        foreach ($order as $item) {
            $totalAmount += (float) str_replace('£', '', $item->unit_price);
        }

        // Initialize PDF content
        $pdfContent = view('pdf.bill', [
            'customer' => $customer,
            'order' => $order,
            'totalAmount' => $totalAmount,
            'currentDate' => now()->format('d F Y'),  // Current date in the desired format
            
        ])->render();

        // Initialize MPDF and write HTML content
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($pdfContent);

        // Output the PDF to the browser
        return $mpdf->Output('bill-' . $orderId . '.pdf', 'I');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // Specify the table name
    protected $table = 'orders';

    // No primary key is set
    protected $primaryKey = null;

    // Disable auto-increment since there is no primary key
    public $incrementing = false;

    // Disable timestamps as the table doesn't have created_at and updated_at
    public $timestamps = false;

    // Allow mass assignment for these fields
    protected $fillable = ['order_id', 'food_id', 'fsub_categ_id', 'fitem_id', 'custormer_id', 'order_date', 'payment', 'delivered', 'qr_code'];

    // You can define a custom function to handle composite key queries if needed
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'food_item';

    // Specify the primary key
    protected $primaryKey = 'fitem_id';

    // Enable auto-increment for the primary key
    public $incrementing = false;

    // Specify the primary key type
    protected $keyType = 'int';

    // Disable timestamps as the table doesn't have created_at and updated_at
    public $timestamps = false;

    // Allow mass assignment for these fields
    protected $fillable = ['item_description', 'unit_price', 'fsub_categ_id', 'food_id'];

    // Define the relationship with the FoodSubCateg model (Many-to-One)
    public function foodSubCategory()
    {
        return $this->belongsTo(FoodSubCateg::class, 'fsub_categ_id', 'fsub_categ_id');
    }

    // Define the relationship with the Food model (Many-to-One)
    public function food()
    {
        return $this->belongsTo(FoodCateg::class, 'food_id', 'food_id');
    }
}

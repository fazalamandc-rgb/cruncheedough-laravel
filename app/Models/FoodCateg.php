<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCateg extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'food_categ';

    // Specify the primary key
    protected $primaryKey = 'food_id';

    // Enable auto-increment for the primary key
    public $incrementing = false;

    // Specify the primary key type
    protected $keyType = 'int';

    // Disable timestamps as the table doesn't have created_at and updated_at
    public $timestamps = false;

    // Allow mass assignment for these fields
    protected $fillable = ['Descriptions'];
}

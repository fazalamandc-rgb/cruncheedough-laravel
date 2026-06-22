<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'customers';

    // Specify the primary key
    protected $primaryKey = 'customer_id';

    // Disable auto-increment since customer_id is not an integer
    public $incrementing = false;

    // Specify the primary key type
    protected $keyType = 'string';

    // Disable timestamps since the table doesn't have created_at and updated_at
    public $timestamps = false;

    // Allow mass assignment for these fields
    protected $fillable = ['customer_id', 'customer_name'];
}

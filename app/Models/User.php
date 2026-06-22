<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'users';

    // Specify the primary key
    protected $primaryKey = 'User_Id';

    // Disable auto-increment if necessary
    public $incrementing = true;

    // Specify the primary key type
    protected $keyType = 'int';

    // Disable timestamps if not using created_at and updated_at
    public $timestamps = false;

    // Allow mass assignment for these fields
    protected $fillable = ['User_Name', 'Password', 'Admin'];
}

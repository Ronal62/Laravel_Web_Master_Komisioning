<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_admin'; // Specify the table name
    protected $primaryKey = 'id_admin'; // Specify primary key
    protected $fillable = [
        'nama_admin',
        'username',
        'password',
    ];

    // Optional: Hide password from JSON output
    protected $hidden = ['password'];
}

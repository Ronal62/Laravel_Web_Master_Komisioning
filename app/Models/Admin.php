<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'tb_admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['nama_admin', 'username', 'password', 'temp_password'];

    // Disable auto-incrementing if not using id_admin as auto-incrementing
    // public $incrementing = false; // Uncomment if id_admin is not auto-incrementing
}

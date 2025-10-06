<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sectoral extends Model
{
    protected $table = 'tb_sectoral';
    protected $primaryKey = 'id_sec';
    public $incrementing = true;
    protected $fillable = ['nama_sec'];
    public $timestamps = false;
}

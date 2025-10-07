<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modem extends Model
{
    protected $table = 'tb_modem';
    protected $primaryKey = 'id_modem';
    public $incrementing = true;
    protected $fillable = ['nama_modem','sinyal'];
    public $timestamps = false;
    
}
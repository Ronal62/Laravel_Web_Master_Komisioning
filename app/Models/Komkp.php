<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komkp extends Model
{
    protected $table = 'tb_komkp';
    protected $primaryKey = 'id_komkp';
    public $incrementing = true;
    protected $fillable = ['jenis_komkp'];
    public $timestamps = false;
}

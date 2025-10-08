<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picmaster extends Model
{
    protected $table = 'tb_picmaster';
    protected $primaryKey = 'id_picmaster';
    public $incrementing = true;
    protected $fillable = ['nama_picmaster'];
    public $timestamps = false;
}

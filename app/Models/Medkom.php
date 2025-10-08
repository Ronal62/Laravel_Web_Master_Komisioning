<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medkom extends Model
{
    protected $table = 'tb_medkom';
    protected $primaryKey = 'id_medkom';
    public $incrementing = true;
    protected $fillable = ['nama_medkom'];
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerkLbs extends Model
{
    protected $table = 'tb_merklbs';
    protected $primaryKey = 'id_merkrtu';
    public $incrementing = true;
    protected $fillable = ['nama_merklbs'];
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelaksanaRTU extends Model
{
    protected $table = 'tb_pelaksana_rtu';
    protected $primaryKey = 'id_pelrtu';
    public $incrementing = true;
    protected $fillable = ['nama_pelrtu', 'foto_ttd'];
    public $timestamps = false;
}

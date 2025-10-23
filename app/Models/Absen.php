<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'tb_absensi';

    protected $primaryKey = 'id_absens';

    public $incrementing = true;

    protected $fillable = [
        'nama_absen',
        'tgl_absen',
        'jenis_absen',
        'ket_absen',
    ];

   public $timestamps = false;
}

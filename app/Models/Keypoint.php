<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Keypoint extends Model
{
    use HasFactory;

    protected $table = 'tb_formkp';

    protected $primaryKey = 'id_formkp';

    public $incrementing = true;

    protected $fillable = [
        'tgl_komisioning',
        'nama_lbs',
        'id_merkrtu',
        'id_modem',
        'rtu_addrs',
        'id_medkom',
        'ip_kp',
        'id_gi',
        'nama_peny',
        'id_sec',
        's_cb',
        's_cb2',
        's_lr',
        's_door',
        's_acf',
        's_dcf',
        's_dcd',
        's_hlt',
        's_sf6',
        's_fir',
        's_fis',
        's_fit',
        's_fin',
        's_comf',
        's_lruf',
        'c_cb',
        'c_cb2',
        'c_hlt',
        'c_rst',
        'ir_rtu',
        'ir_ms',
        'ir_scale',
        'is_rtu',
        'is_ms',
        'is_scale',
        'it_rtu',
        'it_ms',
        'it_scale',
        'vr_rtu',
        'vr_ms',
        'vr_scale',
        'vs_rtu',
        'vs_ms',
        'vs_scale',
        'vt_rtu',
        'vt_ms',
        'vt_scale',
        'sign_kp',
        'id_komkp',
        'nama_user',
        'id_picms',
        'pelrtu',
        'ketkp',
    ];

    protected $casts = [
        'tgl_komisioning' => 'date',
    ];
}

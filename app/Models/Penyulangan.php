<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyulangan extends Model
{
    protected $table = 'tb_formpeny';
    protected $primaryKey = 'id_peny';

    public $timestamps = false;

    protected $fillable = [
        'id_peny',
        'tgl_kom',
        'nama_peny',
        'id_gi',
        'id_rtugi',
        'rtu_addrs',
        'id_medkom',
        's_cb',
        's_lr',
        's_ocr',
        's_ocri',
        's_dgr',
        's_cbtr',
        's_ar',
        's_aru',
        's_tc',
        'c_cb',
        'c_aru',
        'c_rst',
        'c_tc',
        'ir_rtu',
        'is_rtu',
        'it_rtu',
        'ir_ms',
        'is_ms',
        'it_ms',
        'ir_scale',
        'is_scale',
        'it_scale',
        'fir_rtu',
        'fis_rtu',
        'fit_rtu',
        'fin_rtu',
        'fir_ms',
        'fis_ms',
        'fit_ms',
        'fin_ms',
        'fir_scale',
        'fis_scale',
        'fit_scale',
        'fin_scale',
        'p_rtu',
        'p_ms',
        'p_scale',
        'v_rtu',
        'v_ms',
        'v_scale',
        'f_rtu',
        'f_ms',
        'f_scale',
        'id_komkp',
        'nama_user',
        'id_pelms',
        'pelrtu',
        'ketpeny',
        'lastupdate',
    ];
}
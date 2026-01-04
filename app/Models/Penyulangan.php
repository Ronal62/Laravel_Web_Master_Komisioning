<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyulangan extends Model
{
    protected $table = 'tb_formpeny';
    protected $primaryKey = 'id_peny';

    public $timestamps = false;

    protected $fillable = [
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

        // RTU
        'ifr_rtu',
        'ifs_rtu',
        'ift_rtu',
        'ifn_rtu',
        'ifr_psuedo_rtu',
        'ifs_psuedo_rtu',
        'ift_psuedo_rtu',
        'ifn_psuedo_rtu',

        // MS
        'ifr_ms',
        'ifs_ms',
        'ift_ms',
        'ifn_ms',
        'ifr_psuedo_ms',
        'ifs_psuedo_ms',
        'ift_psuedo_ms',
        'ifn_psuedo_ms',

        // Scale
        'ifr_scale',
        'ifs_scale',
        'ift_scale',
        'ifn_scale',
        'ifr_psuedo_scale',
        'ifs_psuedo_scale',
        'ift_psuedo_scale',
        'ifn_psuedo_scale',

        'kv0_rtu',
        'kv0_ms',
        'kv0_scale',

        'ir_address',
        'is_address',
        'it_address',
        'ir_objfrmt',
        'is_objfrmt',
        'it_objfrmt',

        // Address
        'ifr_address',
        'ifs_address',
        'ift_address',
        'ifn_address',
        'ifr_psuedo_address',
        'ifs_psuedo_address',
        'ift_psuedo_address',
        'ifn_psuedo_address',

        // Objfrmt
        'ifr_objfrmt',
        'ifs_objfrmt',
        'ift_objfrmt',
        'ifn_objfrmt',
        'ifr_psuedo_objfrmt',
        'ifs_psuedo_objfrmt',
        'ift_psuedo_objfrmt',
        'ifn_psuedo_objfrmt',

        'kv0_address',
        'kv0_objfrmt',

        // Title Fields
        't_ir',
        't_is',
        't_it',
        't_ifr',
        't_ifs',
        't_ift',
        't_ifn',
        't_ifr_psuedo',
        't_ifs_psuedo',
        't_ift_psuedo',
        't_ifn_psuedo',

        // Title KV0 (Updated to match DB)
        't_kv0',


        'id_komkp',
        'nama_user',
        'id_pelms',
        'id_pelrtu',
        'catatanpeny',
        'lastupdate',
        'scb_open_address',
        'scb_close_address',
        'slocal_address',
        'sremote_address',
        'socr_dis_address',
        'socr_app_address',
        'socri_dis_address',
        'socri_app_address',
        'sdgr_dis_address',
        'sdgr_app_address',
        'scbtr_dis_address',
        'scbtr_app_address',
        'sar_dis_address',
        'sar_app_address',
        'saru_dis_address',
        'saru_app_address',
        'stc_dis_address',
        'stc_app_address',
        'scb_open_objfrmt',
        'scb_close_objfrmt',
        'slocal_objfrmt',
        'sremote_objfrmt',
        'socr_dis_objfrmt',
        'socr_app_objfrmt',
        'socri_dis_objfrmt',
        'socri_app_objfrmt',
        'sdgr_dis_objfrmt',
        'sdgr_app_objfrmt',
        'scbtr_dis_objfrmt',
        'scbtr_app_objfrmt',
        'sar_dis_objfrmt',
        'sar_app_objfrmt',
        'saru_dis_objfrmt',
        'saru_app_objfrmt',
        'stc_dis_objfrmt',
        'stc_app_objfrmt',
        'ccb_open_address',
        'ccb_close_address',
        'caru_use_address',
        'caru_unuse_address',
        'creset_on_address',
        'ctc_raiser_address',
        'ctc_lower_address',
        'ccb_open_objfrmt',
        'ccb_close_objfrmt',
        'caru_use_objfrmt',
        'caru_unuse_objfrmt',
        'creset_on_objfrmt',
        'ctc_raiser_objfrmt',
        'ctc_lower_objfrmt',
        'ketfd',
        'ketfts',
        'ketpk',
        'ketftc',
        'ketftm',
    ];
}

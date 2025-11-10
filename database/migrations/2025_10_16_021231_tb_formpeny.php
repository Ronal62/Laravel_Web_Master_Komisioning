<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_formpeny', function (Blueprint $table) {
            $table->integer('id_peny')->autoIncrement();
            $table->date('tgl_kom')->nullable(false);
            $table->string('nama_peny', 100)->nullable(false);
            $table->integer('id_gi')->nullable(false);
            $table->integer('id_rtugi')->nullable(false);
            $table->string('rtu_addrs', 50)->nullable(false);
            $table->integer('id_medkom')->nullable(false);
            $table->string('s_cb', 100)->nullable(true);
            $table->string('s_lr', 100)->nullable(true);
            $table->string('s_ocr', 100)->nullable(true);
            $table->string('s_ocri', 100)->nullable(true);
            $table->string('s_dgr', 100)->nullable(true);
            $table->string('s_cbtr', 100)->nullable(true);
            $table->string('s_ar', 100)->nullable(true);
            $table->string('s_aru', 100)->nullable(true);
            $table->string('s_tc', 150)->nullable(true);
            $table->string('c_cb', 150)->nullable(true);
            $table->string('c_aru', 150)->nullable(true);
            $table->string('c_rst', 150)->nullable(true);
            $table->string('c_tc', 100)->nullable(true);
            $table->string('ir_rtu', 10)->nullable(true);
            $table->string('is_rtu', 10)->nullable(true);
            $table->string('it_rtu', 10)->nullable(true);
            $table->string('ir_ms', 10)->nullable(true);
            $table->string('is_ms', 10)->nullable(true);
            $table->string('it_ms', 10)->nullable(true);
            $table->string('ir_scale', 10)->nullable(true);
            $table->string('is_scale', 10)->nullable(true);
            $table->string('it_scale', 10)->nullable(true);
            $table->string('fir_rtu', 50)->nullable(true);
            $table->string('fis_rtu', 50)->nullable(true);
            $table->string('fit_rtu', 50)->nullable(true);
            $table->string('fin_rtu', 50)->nullable(true);
            $table->string('fir_ms', 50)->nullable(true);
            $table->string('fis_ms', 50)->nullable(true);
            $table->string('fit_ms', 50)->nullable(true);
            $table->string('fin_ms', 50)->nullable(true);
            $table->string('fir_scale', 50)->nullable(true);
            $table->string('fis_scale', 50)->nullable(true);
            $table->string('fit_scale', 50)->nullable(true);
            $table->string('fin_scale', 50)->nullable(true);
            $table->string('p_rtu', 50)->nullable(true);
            $table->string('p_ms', 50)->nullable(true);
            $table->string('p_scale', 50)->nullable(true);
            $table->string('v_rtu', 50)->nullable(true);
            $table->string('v_ms', 50)->nullable(true);
            $table->string('v_scale', 50)->nullable(true);
            $table->string('f_rtu', 50)->nullable(true);
            $table->string('f_ms', 50)->nullable(true);
            $table->string('f_scale', 50)->nullable(true);
            $table->integer('id_komkp')->nullable(false);
            $table->string('nama_user', 10)->nullable(false);
            $table->string('id_pelms', 50)->nullable(false);
            $table->string('id_pelrtu', 100)->nullable(false);
            $table->string('ketpeny', 1000)->nullable(false);
            $table->string('scb_open_address', 100)->nullable(true);
            $table->string('scb_close_address', 100)->nullable(true);
            $table->string('slocal_address', 100)->nullable(true);
            $table->string('sremote_address', 100)->nullable(true);
            $table->string('socr_dis_address', 100)->nullable(true);
            $table->string('socr_app_address', 100)->nullable(true);
            $table->string('socri_dis_address', 100)->nullable(true);
            $table->string('socri_app_address', 100)->nullable(true);
            $table->string('sdgr_dis_address', 100)->nullable(true);
            $table->string('sdgr_app_address', 100)->nullable(true);
            $table->string('scbtr_dis_address', 100)->nullable(true);
            $table->string('scbtr_app_address', 100)->nullable(true);
            $table->string('sar_dis_address', 100)->nullable(true);
            $table->string('sar_app_address', 100)->nullable(true);
            $table->string('saru_dis_address', 100)->nullable(true);
            $table->string('saru_app_address', 100)->nullable(true);
            $table->string('stc_dis_address', 100)->nullable(true);
            $table->string('stc_app_address', 100)->nullable(true);
            $table->string('scb_open_objfrmt', 100)->nullable(true);
            $table->string('scb_close_objfrmt', 100)->nullable(true);
            $table->string('slocal_objfrmt', 100)->nullable(true);
            $table->string('sremote_objfrmt', 100)->nullable(true);
            $table->string('socr_dis_objfrmt', 100)->nullable(true);
            $table->string('socr_app_objfrmt', 100)->nullable(true);
            $table->string('socri_dis_objfrmt', 100)->nullable(true);
            $table->string('socri_app_objfrmt', 100)->nullable(true);
            $table->string('sdgr_dis_objfrmt', 100)->nullable(true);
            $table->string('sdgr_app_objfrmt', 100)->nullable(true);
            $table->string('scbtr_dis_objfrmt', 100)->nullable(true);
            $table->string('scbtr_app_objfrmt', 100)->nullable(true);
            $table->string('sar_dis_objfrmt', 100)->nullable(true);
            $table->string('sar_app_objfrmt', 100)->nullable(true);
            $table->string('saru_dis_objfrmt', 100)->nullable(true);
            $table->string('saru_app_objfrmt', 100)->nullable(true);
            $table->string('stc_dis_objfrmt', 100)->nullable(true);
            $table->string('stc_app_objfrmt', 100)->nullable(true);
            $table->string('ccb_open_address', 100)->nullable(true);
            $table->string('ccb_close_address', 100)->nullable(true);
            $table->string('caru_use_address', 100)->nullable(true);
            $table->string('caru_unuse_address', 100)->nullable(true);
            $table->string('creset_on_address', 100)->nullable(true);
            $table->string('ctc_raiser_address', 100)->nullable(true);
            $table->string('ctc_lower_address', 100)->nullable(true);
            $table->string('ccb_open_objfrmt', 100)->nullable(true);
            $table->string('ccb_close_objfrmt', 100)->nullable(true);
            $table->string('caru_use_objfrmt', 100)->nullable(true);
            $table->string('caru_unuse_objfrmt', 100)->nullable(true);
            $table->string('creset_on_objfrmt', 100)->nullable(true);
            $table->string('ctc_raiser_objfrmt', 100)->nullable(true);
            $table->string('ctc_lower_objfrmt', 100)->nullable(true);
            $table->timestamp('lastupdate', 6)->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)'));
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('tb_formpeny')->truncate();
        Schema::dropIfExists('tb_formpeny');
    }
};
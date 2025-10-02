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
        Schema::create('tb_merklbs', function (Blueprint $table) {
            $table->integer('id_merkrtu')->autoIncrement();
            $table->string('nama_merklbs', 25);
            $table->primary('id_merkrtu');
        });

        // Seed initial data
        DB::table('tb_merklbs')->insert([
            ['id_merkrtu' => 1, 'nama_merklbs' => 'KWANGMYUNG'],
            ['id_merkrtu' => 2, 'nama_merklbs' => 'VAMP 40'],
            ['id_merkrtu' => 3, 'nama_merklbs' => 'ABB REC 615'],
            ['id_merkrtu' => 4, 'nama_merklbs' => 'SCHNEIDER ADVC'],
            ['id_merkrtu' => 5, 'nama_merklbs' => 'SHINSUNG'],
            ['id_merkrtu' => 6, 'nama_merklbs' => 'VAMP 52'],
            ['id_merkrtu' => 7, 'nama_merklbs' => 'JOONGWON'],
            ['id_merkrtu' => 8, 'nama_merklbs' => 'COOPER AEP'],
            ['id_merkrtu' => 9, 'nama_merklbs' => 'ABB NEOPIS'],
            ['id_merkrtu' => 10, 'nama_merklbs' => 'ABB REF 615'],
            ['id_merkrtu' => 11, 'nama_merklbs' => 'ABB REC 523E'],
            ['id_merkrtu' => 12, 'nama_merklbs' => 'ABB REC 523F'],
            ['id_merkrtu' => 13, 'nama_merklbs' => 'ABB PCD'],
            ['id_merkrtu' => 14, 'nama_merklbs' => 'INES TECHPRO'],
            ['id_merkrtu' => 15, 'nama_merklbs' => 'COOPER'],
            ['id_merkrtu' => 16, 'nama_merklbs' => 'S & S'],
            ['id_merkrtu' => 17, 'nama_merklbs' => 'ENTECH ETMFC'],
            ['id_merkrtu' => 18, 'nama_merklbs' => 'NULEC'],
            ['id_merkrtu' => 19, 'nama_merklbs' => 'MICOMP'],
            ['id_merkrtu' => 20, 'nama_merklbs' => 'JINKWANG P200'],
            ['id_merkrtu' => 21, 'nama_merklbs' => 'SCHNEIDER'],
            ['id_merkrtu' => 22, 'nama_merklbs' => 'JOONGNAM (NON-RTU)'],
            ['id_merkrtu' => 23, 'nama_merklbs' => 'INES VITZRO'],
            ['id_merkrtu' => 24, 'nama_merklbs' => 'SIECOM'],
            ['id_merkrtu' => 25, 'nama_merklbs' => 'GATEWAY'],
            ['id_merkrtu' => 26, 'nama_merklbs' => 'ENTECH ETR'],
            ['id_merkrtu' => 27, 'nama_merklbs' => 'SINTRA'],
            ['id_merkrtu' => 28, 'nama_merklbs' => 'HEZONG'],
            ['id_merkrtu' => 29, 'nama_merklbs' => 'MODIF'],
            ['id_merkrtu' => 30, 'nama_merklbs' => 'BRODERSEN'],
            ['id_merkrtu' => 31, 'nama_merklbs' => 'YASKAWA OML'],
            ['id_merkrtu' => 32, 'nama_merklbs' => 'YASKAWA'],
            ['id_merkrtu' => 33, 'nama_merklbs' => 'JINGWANG'],
            ['id_merkrtu' => 34, 'nama_merklbs' => 'DONGNAM (NON RTU)'],
            ['id_merkrtu' => 35, 'nama_merklbs' => 'ENTEC EVRC2A-NT'],
            ['id_merkrtu' => 36, 'nama_merklbs' => 'SIEMENS'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_merklbs');
    }
};
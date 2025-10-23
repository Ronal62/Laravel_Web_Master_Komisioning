<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_absensi', function (Blueprint $table) {
            $table->integer('id_absens')->autoIncrement();
            $table->string('nama_absen', 25);
            $table->dateTime('tgl_absen');
            $table->enum('jenis_absen', ['Clock In', 'Clock Out']);
            $table->string('ket_absen', 50);
            $table->timestamp('lastupdate')->useCurrent()->useCurrentOnUpdate();
            $table->engine = 'InnoDB';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
        });

        DB::table('tb_absensi')->insert([
            ['id_absens' => 19, 'nama_absen' => 'Mulyadi', 'tgl_absen' => '2021-09-16 16:52:53', 'jenis_absen' => 'Clock Out', 'ket_absen' => '', 'lastupdate' => '2021-09-16 09:52:57'],
            ['id_absens' => 20, 'nama_absen' => 'Rizky', 'tgl_absen' => '2021-09-16 16:55:35', 'jenis_absen' => 'Clock Out', 'ket_absen' => '', 'lastupdate' => '2021-09-16 09:55:38'],
            ['id_absens' => 22, 'nama_absen' => 'Rizky', 'tgl_absen' => '2021-09-17 07:40:15', 'jenis_absen' => 'Clock In', 'ket_absen' => '', 'lastupdate' => '2021-09-17 00:40:20'],
            ['id_absens' => 23, 'nama_absen' => 'Nila', 'tgl_absen' => '2021-09-17 07:40:59', 'jenis_absen' => 'Clock In', 'ket_absen' => '', 'lastupdate' => '2021-09-17 00:41:03'],
            ['id_absens' => 24, 'nama_absen' => 'Mulyadi', 'tgl_absen' => '2021-09-17 07:46:42', 'jenis_absen' => 'Clock In', 'ket_absen' => '', 'lastupdate' => '2021-09-17 00:46:49'],
            ['id_absens' => 31, 'nama_absen' => 'Nila', 'tgl_absen' => '2021-09-17 16:00:14', 'jenis_absen' => 'Clock Out', 'ket_absen' => '', 'lastupdate' => '2021-09-17 09:00:19'],
            ['id_absens' => 32, 'nama_absen' => 'Mulyadi', 'tgl_absen' => '2021-09-17 16:02:34', 'jenis_absen' => 'Clock Out', 'ket_absen' => '', 'lastupdate' => '2021-09-17 09:02:37'],
            ['id_absens' => 33, 'nama_absen' => 'Rizky', 'tgl_absen' => '2021-09-17 16:03:57', 'jenis_absen' => 'Clock Out', 'ket_absen' => '', 'lastupdate' => '2021-09-17 09:04:05'],
            ['id_absens' => 34, 'nama_absen' => 'Mulyadi', 'tgl_absen' => '2021-09-20 07:38:25', 'jenis_absen' => 'Clock In', 'ket_absen' => '', 'lastupdate' => '2021-09-20 00:38:28'],
            ['id_absens' => 35, 'nama_absen' => 'Nila', 'tgl_absen' => '2021-09-20 07:48:45', 'jenis_absen' => 'Clock In', 'ket_absen' => '', 'lastupdate' => '2021-09-20 00:48:51'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_absensi');
    }
};

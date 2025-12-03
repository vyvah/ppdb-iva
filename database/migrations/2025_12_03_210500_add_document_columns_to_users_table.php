<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Document file columns
            $table->string('kk')->nullable()->after('email_verified_at');
            $table->string('akte')->nullable()->after('kk');
            $table->string('bukti_transfer')->nullable()->after('akte');

            // Parent/Guardian data columns
            $table->string('nama_ayah')->nullable()->after('bukti_transfer');
            $table->string('nik_ayah')->nullable()->after('nama_ayah');
            $table->string('pekerjaan_ayah')->nullable()->after('nik_ayah');
            $table->string('telepon_ayah')->nullable()->after('pekerjaan_ayah');

            $table->string('nama_ibu')->nullable()->after('telepon_ayah');
            $table->string('nik_ibu')->nullable()->after('nama_ibu');
            $table->string('pekerjaan_ibu')->nullable()->after('nik_ibu');
            $table->string('telepon_ibu')->nullable()->after('pekerjaan_ibu');

            $table->text('alamat_ortu')->nullable()->after('telepon_ibu');
            $table->string('rt_ortu')->nullable()->after('alamat_ortu');
            $table->string('rw_ortu')->nullable()->after('rt_ortu');
            $table->string('kelurahan_ortu')->nullable()->after('rw_ortu');
            $table->string('kecamatan_ortu')->nullable()->after('kelurahan_ortu');
            $table->string('kabupaten_ortu')->nullable()->after('kecamatan_ortu');
            $table->string('provinsi_ortu')->nullable()->after('kabupaten_ortu');
            $table->string('kode_pos_ortu')->nullable()->after('provinsi_ortu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'kk', 'akte', 'bukti_transfer',
                'nama_ayah', 'nik_ayah', 'pekerjaan_ayah', 'telepon_ayah',
                'nama_ibu', 'nik_ibu', 'pekerjaan_ibu', 'telepon_ibu',
                'alamat_ortu', 'rt_ortu', 'rw_ortu', 'kelurahan_ortu',
                'kecamatan_ortu', 'kabupaten_ortu', 'provinsi_ortu', 'kode_pos_ortu'
            ]);
        });
    }
};

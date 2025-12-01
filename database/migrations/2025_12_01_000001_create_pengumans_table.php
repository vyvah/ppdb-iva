<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengumans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('biodata_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nomor_pendaftaran')->unique();
            $table->string('nama_peserta');
            $table->enum('status_hasil', ['diterima', 'tidak_diterima', 'cadangan'])->default('tidak_diterima');
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->text('pesan_pengumuman')->nullable();
            $table->timestamp('tanggal_pengumuman')->nullable();
            $table->boolean('di_publikasikan')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('biodata_id');
            $table->index('status_hasil');
            $table->index('di_publikasikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumans');
    }
};

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
        Schema::create('wbs_reports', function (Blueprint $table) {
            $table->id();

            // Tracking ID unik untuk setiap laporan
            $table->string('tracking_id')->unique();

            // Relasi ke user pelapor
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'id_user')
                ->onDelete('set null');

            // Data Pengadu
            $table->boolean('is_anonim')->default(false);
            $table->string('nama_pengadu')->nullable();
            $table->string('email_pengadu')->nullable();
            $table->string('telepon_pengadu')->nullable();

            // Data Aduan
            $table->string('nama_terlapor');
            $table->foreignId('wilayah_id')
                ->constrained('wilayah_umum')
                ->onDelete('cascade');
            $table->foreignId('kategori_id')
                ->constrained('kategori_umum')
                ->onDelete('cascade');
            $table->timestamp('waktu_kejadian');
            $table->string('lokasi_kejadian', 100);
            $table->text('uraian');

            // Lampiran
            $table->json('lampiran')->nullable(); // array path upload file

            // Status Aduan
            $table->enum('status', ['Diajukan', 'Dibaca', 'Diproses', 'Selesai'])
                ->default('Diajukan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wbs_reports');
    }
};

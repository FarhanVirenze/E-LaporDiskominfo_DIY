<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Tracking ID unik
            $table->string('tracking_id')->unique();

            // Relasi ke users (nullable, ke kolom id_user)
            $table->foreignId('user_id')->nullable()
                  ->constrained('users', 'id_user')->onDelete('set null');

            // Identitas pengadu
            $table->boolean('is_anonim')->default(false);
            $table->string('nama_pengadu')->nullable();
            $table->string('email_pengadu')->nullable();
            $table->string('telepon_pengadu')->nullable();
            $table->string('nik')->nullable();

            // Konten laporan
            $table->string('judul');
            $table->text('isi');
            $table->foreignId('kategori_id')->constrained('kategori_umum')->onDelete('cascade');
            $table->foreignId('wilayah_id')->constrained('wilayah_umum')->onDelete('cascade');
            $table->json('file');

            // Lokasi
            $table->string('lokasi'); // alamat lengkap
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            // Statistik laporan
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('dislikes')->default(0);

            // Status laporan
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai'])->default('Diajukan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

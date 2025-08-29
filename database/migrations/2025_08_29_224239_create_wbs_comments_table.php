<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wbs_comments', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel laporan WBS
            $table->foreignId('report_id')
                ->constrained('wbs_reports')
                ->onDelete('cascade');

            // Relasi ke user (pastikan PK di users = id_user)
            $table->foreignId('user_id')
                ->constrained('users', 'id_user')
                ->onDelete('cascade');

            $table->text('pesan'); // isi komentar
            $table->string('file')->nullable(); // File pendukung
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wbs_comments');
    }
};

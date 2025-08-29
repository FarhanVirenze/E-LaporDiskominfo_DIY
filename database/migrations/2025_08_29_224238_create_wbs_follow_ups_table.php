<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wbs_follow_ups', function (Blueprint $table) {
            $table->id();

            // relasi ke laporan utama (wbs_reports)
            $table->foreignId('report_id')
                ->constrained('wbs_reports')
                ->onDelete('cascade');

            // user yang menindaklanjuti
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'id_user') // fix disini
                ->onDelete('set null');

            $table->text('deskripsi')->nullable(); // isi tindak lanjut
            $table->string('lampiran')->nullable(); // simpan file jika ada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wbs_follow_ups');
    }
};

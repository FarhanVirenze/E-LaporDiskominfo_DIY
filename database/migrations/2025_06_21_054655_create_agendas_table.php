<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
    $table->id('id_agenda');

    $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
    $table->foreignId('id_ruangan')->constrained('ruangans', 'id_ruangan')->onDelete('cascade');

    $table->string('nm_agenda');
    $table->date('tanggal');
    $table->time('waktu');
    $table->text('deskripsi')->nullable();

    $table->foreignId('id_pic')->nullable()->constrained('users', 'id_user')->nullOnDelete(); // PIC

    $table->enum('status', ['diajukan', 'disetujui', 'ditolak'])->default('diajukan');
    $table->foreignId('approved_by')->nullable()->constrained('users', 'id_user')->nullOnDelete();
    $table->timestamp('approved_at')->nullable();

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};

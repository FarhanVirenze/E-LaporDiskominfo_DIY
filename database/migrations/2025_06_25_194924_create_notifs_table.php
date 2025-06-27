<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifs', function (Blueprint $table) {
            $table->id('id_notif');

            // Foreign key ke users
            $table->foreignId('id_user')
                  ->constrained('users', 'id_user')
                  ->onDelete('cascade');

            $table->string('jenis_notif');
            $table->string('keterangan');

            $table->enum('status', ['terbaca', 'belum terbaca'])->default('belum terbaca');
            $table->date('tanggal');
            $table->time('waktu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('isi_rapats', function (Blueprint $table) {
            $table->id('id_rapat');

            // Foreign key ke users
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            // Foreign key ke agendas
            $table->foreignId('id_agenda')->constrained('agendas', 'id_agenda')->onDelete('cascade');

            $table->text('pembahasan');
    
            // Status: open, progress, selesai
           $table->enum('status', ['open', 'close'])->default('open');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isi_rapats');
    }
};

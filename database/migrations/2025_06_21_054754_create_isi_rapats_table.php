<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('isi_rapats', function (Blueprint $table) {
            $table->id('id_rapat');

            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('id_agenda')->nullable();
            $table->foreign('id_agenda')->references('id_agenda')->on('agendas')->onDelete('cascade');

            $table->text('pembahasan');
            $table->enum('status', ['open', 'close'])->default('open');

            // Jika kamu memang ingin menyimpan nama PIC
            $table->string('pic')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isi_rapats');
    }
};

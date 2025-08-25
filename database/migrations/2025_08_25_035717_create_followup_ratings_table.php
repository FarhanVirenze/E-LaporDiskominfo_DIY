<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('followup_ratings', function (Blueprint $table) {
            $table->id();

            // Relasi ke follow_ups.id
            $table->unsignedBigInteger('followup_id');
            $table->foreign('followup_id')
                ->references('id')
                ->on('follow_ups')
                ->onDelete('cascade');

            // Relasi ke users.id_user
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->tinyInteger('rating'); // nilai rating 1-5
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Optional: satu user hanya bisa rating sekali per tindak lanjut
            $table->unique(['followup_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followup_ratings');
    }
};

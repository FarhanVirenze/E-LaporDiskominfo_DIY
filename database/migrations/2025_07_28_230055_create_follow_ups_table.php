<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')
                ->constrained('reports')
                ->onDelete('cascade');

            // foreign ke users.id_user (bukan users.id)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->text('pesan');
            $table->string('file')->nullable(); // foto / dokumen
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};

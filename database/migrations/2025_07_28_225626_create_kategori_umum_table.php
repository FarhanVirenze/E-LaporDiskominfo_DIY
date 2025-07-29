<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori_umum', function (Blueprint $table) {
            $table->id();
            $table->string('nama');

            $table->foreignId('admin_id')
                ->nullable() // ✅ wajib ini
                ->constrained('users', 'id_user')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_umum');
    }
};

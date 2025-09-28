<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan kolom 'status' sudah ada
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai', 'Arsip'])
                  ->default('Diajukan')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('status', ['Diajukan', 'Dibaca', 'Direspon', 'Selesai'])
                  ->default('Diajukan')
                  ->change();
        });
    }
};

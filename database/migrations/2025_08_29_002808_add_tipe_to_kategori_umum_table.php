<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kategori_umum', function (Blueprint $table) {
            $table->enum('tipe', ['wbs_admin', 'non_wbs_admin'])
                  ->default('non_wbs_admin')
                  ->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_umum', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
};

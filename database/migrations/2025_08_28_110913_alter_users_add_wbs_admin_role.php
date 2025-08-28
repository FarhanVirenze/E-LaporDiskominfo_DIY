<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ubah enum role jadi tambah opsi wbs_admin
            $table->enum('role', ['user', 'admin', 'superadmin', 'wbs_admin'])
                  ->default('user')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // rollback ke enum awal
            $table->enum('role', ['user', 'admin', 'superadmin'])
                  ->default('user')
                  ->change();
        });
    }
};

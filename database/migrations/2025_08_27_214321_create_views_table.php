<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('viewable_type');      // tipe (page, post, dll)
            $table->string('viewable_id');        // pakai string biar bisa hash
            $table->string('visitor')->nullable();     // hash unik ip+ua
            $table->string('ip_address')->nullable();  // ip asli
            $table->text('user_agent')->nullable();    // user agent asli
            $table->string('collection')->nullable();  // path/url
            $table->timestamp('viewed_at')->useCurrent();

            // index biar query statistik lebih cepat
            $table->index(['viewable_id', 'visitor']);
            $table->index('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views');
    }
}

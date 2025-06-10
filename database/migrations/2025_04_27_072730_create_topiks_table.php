<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('topiks', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->foreignId('matapelajaran_id')->constrained()->onDelete('cascade');
        $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
        $table->text('konten')->nullable();
        $table->string('file')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topiks');
    }
}

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasMatapelajaranTable extends Migration
{
    public function up()
    {
        Schema::create('kelas_matapelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->foreignId('matapelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['kelas_id', 'matapelajaran_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas_matapelajaran');
    }
}

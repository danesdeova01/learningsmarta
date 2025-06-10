<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKelasIdToTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('tugas', function (Blueprint $table) {
        $table->unsignedBigInteger('kelas_id')->after('id')->nullable();
    });
}

public function down()
{
    Schema::table('tugas', function (Blueprint $table) {
        $table->dropColumn('kelas_id');
    });
}

}

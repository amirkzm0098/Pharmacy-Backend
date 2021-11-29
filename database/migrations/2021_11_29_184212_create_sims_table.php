<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharm_pharm', function (Blueprint $table) {
            $table->id();
            $table->integer('pharm_id_1');
            $table->integer('pharm_id_2');
            $table->timestamps();

            $table->foreign('pharm_id_1')->references('id')->on('pharms')->onDelete('cascade');
            $table->foreign('pharm_id_2')->references('id')->on('pharms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharm_pharm');
    }
}

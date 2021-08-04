<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Naber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('words2', function (Blueprint $table) {
        //     $table->id();
        //     $table->json('json');
        //     $table->timestamps();
        // });

        Schema::rename('words2', 'words');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('words2');
    }
}

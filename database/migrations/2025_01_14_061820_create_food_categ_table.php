<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodCategTable extends Migration
{
    public function up()
    {
        Schema::create('food_categ', function (Blueprint $table) {
            $table->integer('food_id')->primary();  // Assuming food_id is the primary key
            $table->string('Descriptions', 45);
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_categ');
    }
}

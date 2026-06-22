<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodSubCategTable extends Migration
{
    public function up()
    {
        Schema::create('food_sub_categ', function (Blueprint $table) {
            $table->integer('fsub_categ_id')->primary();  // Assuming fsub_categ_id is the primary key
            $table->string('fs_descriptions', 45);
            $table->integer('food_id');  // Foreign key referring to food_categ

            // Add foreign key constraint
            $table->foreign('food_id')->references('food_id')->on('food_categ')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_sub_categ');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodItemTable extends Migration
{
    public function up()
    {
        Schema::create('food_item', function (Blueprint $table) {
            $table->integer('fitem_id')->primary();  // Primary key for the food_item table
            $table->string('item_description', 200);
            $table->string('unit_price', 200);
            $table->integer('fsub_categ_id');  // Foreign key to food_sub_categ table
            $table->integer('food_id');  // Foreign key to food_categ table

            // Add foreign key constraints
            $table->foreign('fsub_categ_id')->references('fsub_categ_id')->on('food_sub_categ')->onDelete('cascade');
            $table->foreign('food_id')->references('food_id')->on('food_categ')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_item');
    }
}

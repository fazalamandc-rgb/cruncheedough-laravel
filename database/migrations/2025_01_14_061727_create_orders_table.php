<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('order_id');
            $table->integer('food_id');
            $table->integer('fsub_categ_id');
            $table->integer('fitem_id');
            $table->string('custormer_id', 45);
            $table->date('order_date');
            $table->integer('payment');
            $table->integer('delivered');
            
            // Define qr_code as AUTO_INCREMENT and UNIQUE
            $table->integer('qr_code')->unique()->autoIncrement();

            // If you want to add any foreign keys or other constraints, you can do that here
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

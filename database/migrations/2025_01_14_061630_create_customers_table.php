<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('customer_id', 45)->primary();  // Assuming customer_id is unique
            $table->string('customer_name', 45);
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}

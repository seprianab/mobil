<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('date');

            $table->integer('customer_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');

            $table->integer('car_id');
            $table->string('car_name');
            $table->double('car_price');

            $table->integer('status')->default(1);  // 1 => active, 2 = cancelled
            $table->softDeletes();
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
        Schema::dropIfExists('sales');
    }
}

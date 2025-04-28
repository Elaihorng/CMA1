<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id')->nullable();
            $table->string('order_number', 50)->change();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('company_name')->nullable();
            $table->text('address');
            $table->text('order_notes')->nullable();
            $table->string('shipping_method');
            $table->string('shipping_address');
            $table->decimal('total_amount', 10, 2);
            $table->string('order_status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->timestamp('order_date');
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
        Schema::dropIfExists('orders');
    }
}

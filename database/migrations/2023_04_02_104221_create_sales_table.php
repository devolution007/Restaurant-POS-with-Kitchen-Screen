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
            $table->string('uuid');
            $table->string('tracking');
            $table->string('order_type')->default('dining');
            $table->longText('items');
            $table->text('tax');
            $table->float('tax_amount')->default(0);
            $table->float('subtotal')->default(0);
            $table->string('cart_total_items')->default(0);
            $table->float('cart_total_price')->default(0);
            $table->float('cart_total_cost')->default(0);
            $table->float('profit_after_all')->default(0);
            $table->float('payable_after_all')->default(0);
            $table->float('discount_rate')->default(0);
            $table->float('discount_amount')->default(0);
            $table->foreignId('table_id')->nullable()->constrained('service_tables');

            $table->foreignId('order_taker_id')->constrained('users');
            $table->timestamp('took_at')->nullable();

            $table->boolean('is_preparing')->default(false);
            $table->foreignId('chef_id')->nullable()->constrained('users');
            $table->timestamp('prepared_at')->nullable();

            $table->float('after_discount')->default(0);

            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->boolean('ordered_online')->default(false);

            $table->foreignId('biller_id')->nullable()->constrained('users');
            $table->timestamp('completed_at')->nullable();

            $table->text('payment_note')->nullable();
            $table->text('staff_note')->nullable();
            $table->integer('progress')->default(0);

            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods');
            $table->text('note_for_chef')->nullable();

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

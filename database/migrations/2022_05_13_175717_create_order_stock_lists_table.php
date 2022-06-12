<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_stock_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_stocks_id')->constrained('order_stocks')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->float('unit_price')->nullable();
            $table->float('unit_total')->nullable();
            $table->enum('status', ['pending', 'receive'])->default('pending');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_stock_lists');
    }
};

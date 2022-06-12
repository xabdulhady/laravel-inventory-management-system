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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('location');
            $table->float('price');
            $table->float('sale_price')->nullable();
            $table->float('tax')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->onDelete('SET NULL');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('order_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->date('issue_date')->nullable();
            $table->date('receipt_date')->nullable();
            $table->float('tax')->nullable();
            $table->string('location');
            $table->text('bill_to');
            $table->boolean('ship_to_check')->default(0);
            $table->text('ship_to')->nullable();
            $table->string('tracking_ref');
            $table->float('final_amount');
            $table->string('shiped_by');
            $table->text('order_note')->nullable();
            $table->text('internal_notes')->nullable();
            $table->enum('status', ['pending', 'receive'])->default('pending');
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
        Schema::dropIfExists('order_stocks');
    }
};

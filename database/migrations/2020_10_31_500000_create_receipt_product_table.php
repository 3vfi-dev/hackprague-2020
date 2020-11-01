<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('warranty')->default(24);
            $table->unsignedSmallInteger('vat')->default(0);
            $table->decimal('price', 10, 1);
            $table->decimal('price_with_vat', 10, 1);
            $table->unsignedInteger('quantity');
            $table->decimal('price_total', 10, 1);
            $table->decimal('price_with_vat_total', 10, 1);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_product');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->char('hash', 128);
            $table->text('custom_text')->nullable();
            $table->string('pkp', 344)->nullable()->unique()->comment('Comes from the EET system');
            $table->char('fik', 39)->nullable()->unique()->comment('Comes from the EET system');
            $table->char('bkp', 44)->unique()->comment('Comes from the EET system');
            $table->unsignedSmallInteger('cash_register')->default(0)->comment('Comes from the EET system');
            $table->unsignedInteger('receipt_number')->default(0)->comment('Comes from the EET system');
            $table->decimal('price_total', 10, 1)->default(0);
            $table->decimal('price_with_vat_total', 10, 1)->default(0);
            $table->unsignedInteger('products_quantity')->default(0);
            $table->timestamps();
            $table->timestamp('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}

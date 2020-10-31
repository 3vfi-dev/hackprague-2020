<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street', 64);
            $table->unsignedInteger('registry_number');
            $table->unsignedSmallInteger('house_number')->default(0);
            $table->string('city', 64);
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
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
        Schema::dropIfExists('addresses');
    }
}

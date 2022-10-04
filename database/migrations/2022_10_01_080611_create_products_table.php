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
            $table->string('product_category');
            $table->string('product_industry');
            $table->string('product_name');
            $table->decimal('product_price');
            $table->string('product_size');
            $table->text('product_descreption');
            $table->string('color')->nullable();
            $table->string('use_case')->nullable();
            $table->string('discount');
            $table->decimal('total_price');
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
        Schema::dropIfExists('products');
    }
};

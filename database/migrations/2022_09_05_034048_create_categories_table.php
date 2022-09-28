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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('industry_id')->unsigned()->index();
            $table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade');
            $table->boolean('status')->nullable();
            $table->string('name');
            $table->string('short_code')->nullable();
            $table->string('thumb')->nullable();
            $table->string('icon')->nullable();
            $table->string('banner')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('created_by')->unsigned()->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('categories');
    }
};

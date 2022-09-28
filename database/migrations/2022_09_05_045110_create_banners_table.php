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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->string('title');
            $table->string('url');
            $table->string('caption')->nullable();
            $table->string('page')->nullable();
            $table->string('type');
            $table->string('thumb');
            $table->string('icon')->nullable();
            $table->string('banner')->nullable();
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
        Schema::dropIfExists('banners');
    }
};

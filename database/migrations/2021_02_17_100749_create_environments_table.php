<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('middleware')->nullable();
            $table->string('prefix')->nullable();
            $table->string('domain');
            $table->boolean('https')->default(false);
            $table->json('options')->nullable();
            $table->string('default_redirect_to')->nullable();
            $table->string('default_redirect_ip')->nullable();
            $table->string('is_bookable')->default(true);
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
        Schema::dropIfExists('environments');
    }
}

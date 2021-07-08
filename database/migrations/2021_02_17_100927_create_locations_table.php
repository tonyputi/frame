<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained();
            $table->string('name');
            $table->string('match');
            $table->string('default_redirect_to')->nullable();
            $table->string('default_redirect_ip')->nullable();
            $table->string('is_bookable')->default(true);
            $table->timestamps();

            $table->unique(['environment_id', 'name']);
            $table->unique(['environment_id', 'match']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}

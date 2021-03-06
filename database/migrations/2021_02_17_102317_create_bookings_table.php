<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->nullable()->constrained();
            $table->foreignId('application_id')->nullable()->constrained();
            $table->foreignId('location_id')->constrained();
            $table->foreignId('user_id')->constrained();
            // $table->boolean('is_active')->default(false);
            $table->text('notes')->nullable();
            $table->datetime('started_at');
            $table->datetime('ended_at');
            $table->datetime('applied_at')->nullable();
            $table->timestamps();

            // TODO: we need to make unique(location_id, started_at, ended_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}

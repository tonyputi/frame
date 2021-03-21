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
            // $table->foreignId('performed_by')->constrained('users', 'id');
            $table->foreignId('environment_id')->nullable()->constrained();
            $table->foreignId('application_id')->nullable()->constrained();
            $table->foreignId('location_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('notes')->nullable();
            $table->datetime('started_at');
            $table->datetime('ended_at');
            $table->datetime('applied_at')->nullable();
            $table->timestamp('notified_at')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}

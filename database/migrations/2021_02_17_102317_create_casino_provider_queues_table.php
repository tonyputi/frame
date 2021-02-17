<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasinoProviderQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casino_provider_queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('environment_id')->constrained();
            $table->foreignId('application_id')->constrained();
            $table->foreignId('game_provider_id')->constrained();
            $table->string('host');
            $table->text('notes')->nullable();
            $table->datetime('started_at');
            $table->datetime('ended_at');
            $table->datetime('applied_at');
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('casino_provider_queues');
    }
}

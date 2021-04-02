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
            $table->string('default_redirect_ipv4')->nullable();
            $table->timestamps();

            // here i need to create a column like default_redirect_hostname and default_redirect_ipv4
            // default_redirect_to
            // default_redirect_ipv4

            // "https": true,
            // "default": {
            //     "redirect": {
            //         "to": "stage-it.videoslots.com",
            //         "ipv4": "192.168.88.22"
            //     }
            // }

            // $options = [
            //     'default' => [
            //         'redirect' => [
            //             'to' => 'stage-it.videoslots.com',
            //             'ipv4' => '192.168.88.22',
            //         ]
            //     ]
            // ];
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->uuid('uuid')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('client_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('posta_area');
            $table->string('street');
            $table->string('number');
            $table->string('city');
            $table->string('state');
            $table->string('building_type');
            $table->string('long');
            $table->string('lat');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_default')->default(false);
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
        Schema::dropIfExists('client_address');
        Schema::dropIfExists('clients');
    }
}

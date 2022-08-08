<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyValueStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_value_store', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->json('val')->nullable();
            $table->string('group')->default('default');
            $table->timestamps();

            $table->unique(['group', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('key_value_store');
    }
}


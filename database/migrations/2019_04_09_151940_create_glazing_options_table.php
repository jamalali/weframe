<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlazingOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glazing_options', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
			$table->double('width');
			$table->double('height');
			$table->double('price');
			$table->boolean('exclude_online')->default(0);
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('glazing_options');
    }
}

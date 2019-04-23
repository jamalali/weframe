<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMountVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mount_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mount_id');
			$table->string('sku');
			$table->string('colour');
			$table->integer('inventory')->nullable();
			$table->double('price')->nullable();
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
        Schema::dropIfExists('mount_variants');
    }
}

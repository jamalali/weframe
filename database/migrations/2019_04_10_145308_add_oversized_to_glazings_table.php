<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOversizedToGlazingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('glazings', function (Blueprint $table) {
            $table->double('oversized_width')->after('price')->nullable();
			$table->double('oversized_height')->after('oversized_width')->nullable();
			$table->double('oversized_price')->after('oversized_height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('glazings', function (Blueprint $table) {
            $table->dropColumn(['oversized_width', 'oversized_height', 'oversized_price']);
        });
    }
}

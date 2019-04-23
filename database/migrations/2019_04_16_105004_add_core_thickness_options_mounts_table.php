<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoreThicknessOptionsMountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mounts', function (Blueprint $table) {
            $table->string('core_colour')->after('oversized_price');
			$table->string('thickness')->after('core_colour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mounts', function (Blueprint $table) {
            $table->dropColumn(['core_colour', 'thickness']);
        });
    }
}

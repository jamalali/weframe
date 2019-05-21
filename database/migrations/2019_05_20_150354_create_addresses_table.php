<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('customer_id')->nullable();
			$table->text('first_name')->nullable();
			$table->text('last_name')->nullable();
			$table->text('company')->nullable();
			$table->text('address_1');
			$table->text('address_2')->nullable();
			$table->text('town');
			$table->text('county')->nullable();
			$table->text('postcode');
			$table->integer('country_id')->default(1);
			$table->text('phone_number')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccoutingExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accouting_exports', function (Blueprint $table) {
            $table->id();
            $table->string('time_ref');
            $table->string('account');
            $table->string('code');
            $table->string('country_code');
            $table->string('product_type');
            $table->string('value');
            $table->string('status');
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
        Schema::dropIfExists('accouting_exports');
    }
}

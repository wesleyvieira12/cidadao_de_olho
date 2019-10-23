<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndemnityAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indemnity_amounts', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount');
            $table->integer('deputy_id')->unsigned();
            $table->foreign('deputy_id')
                ->references('id')->on('deputies')
                ->onDelete('cascade');
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
        Schema::dropIfExists('indemnity_amounts');
    }
}

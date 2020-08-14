<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate, 10');
            $table->string('brand', 20);
            $table->string('type', 20);
            $table->string('model', 50);
            $table->foreignId('owner_id');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
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
        Schema::dropIfExists('vehicles', function(Blueprint $table){
            $table->dropForeign('vehicles_owner_id_foreign');
            $table->dropIndex('vehicles_owner_id_foreign');
            $table->dropColumn('owner_id');
        });
    }
}

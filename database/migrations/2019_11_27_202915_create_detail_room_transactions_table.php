<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailRoomTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_room_transactions', function (Blueprint $table) {
            $table->uuid('roomTransactionID');
            $table->string('roomID');
            $table->integer('shiftStart');
            $table->integer('shiftEnd');
            $table->string('reason')->nullable(true);
            $table->boolean('internetRequest');
            $table->uuid('userID1')->nullable(true);
            $table->uuid('userID2')->nullable(true);

            $table->softDeletes();
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
        Schema::dropIfExists('detail_room_transactions');
    }
}

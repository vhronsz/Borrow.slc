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
            $table->integer('shiftStart');
            $table->integer('shiftEnd');
            $table->boolean('internetRequest');
            $table->string('internetReason')->nullable(true);
            $table->string('assistant')->nullable(true);
            $table->string('borrower');
            $table->string("borrowReason");

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

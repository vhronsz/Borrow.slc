<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderRoomTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_room_transactions', function (Blueprint $table) {

            $table->uuid('roomTransactionID');
            $table->uuid('adminID');
            $table->dateTime('transactionDate');
            $table->string("transactionStatus");
            $table->string("campus");
            $table->string('roomID');

            $table->string('borrowerName');
            $table->string('borrowerEmail');
            $table->string('borrowerPhone');
            $table->string('borrowerDivision');
            $table->string("borrowReason");

            $table->integer("shiftStart");
            $table->integer("shiftEnd");

            $table->boolean('internetRequest');
            $table->string('internetReason')->nullable(true);
            $table->string('assistant')->nullable(true);

            $table->softDeletes();
            $table->timestamps();
            $table->primary("roomTransactionID");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('header_room_transactions');
    }
}

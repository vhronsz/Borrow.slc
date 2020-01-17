<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderItemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_item_transactions', function (Blueprint $table) {
            $table->uuid('itemTransactionID');
            $table->uuid('adminID');
            $table->uuid('userID');
            $table->dateTime('transactionDate');
            $table->

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
        Schema::dropIfExists('header_item_transactions');
    }
}

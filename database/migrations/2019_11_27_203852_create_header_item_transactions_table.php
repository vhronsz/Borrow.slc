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
            $table->string('username');
            $table->string('userEmail');
            $table->string('userPhone');
            $table->dateTime('transactionDate');
            $table->string("transactionStatus");

            $table->primary("itemTransactionID");
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

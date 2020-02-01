<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailItemTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_item_transactions', function (Blueprint $table) {
            $table->uuid('itemTransactionID');
            $table->uuid('itemID');
            $table->date('shiftStart');
            $table->date('shiftEnd');
            $table->string('bookType');
            $table->string('status');

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
        Schema::dropIfExists('detail_item_transactions');
    }
}

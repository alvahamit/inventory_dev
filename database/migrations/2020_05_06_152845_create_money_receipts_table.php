<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('mr_date');
            $table->string('mr_no');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->string('customer_name');
            $table->string('customer_company')->nullable();
            $table->text('customer_address');
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('pay_mode');
            $table->integer('cheque_no')->unsigned()->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bkash_tr_no')->nullable();
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
        Schema::dropIfExists('money_receipts');
    }
}

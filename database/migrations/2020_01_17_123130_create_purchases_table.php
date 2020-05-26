<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_no');
            $table->date('receive_date');
            $table->integer('user_id')->comment('User who is registered as supplier.');
            $table->string('purchase_type')->comment('This should be either Import or Local purchase'); 
            $table->double('total',15,2); 
            $table->timestamps();
        });
    }
    //Note: Default float is total 8 digit including 2 pricision.
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWastagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wastages', function (Blueprint $table) {
            $table->id();
            $table->string('wastage_no')->unique()->index();
            $table->date('wastage_date');
            $table->string('wasted_at');
            $table->integer('store_id')->nullable();
            $table->string('store_name')->nullable();
            $table->string('quantity_type');
            $table->string('issued_by');
            $table->text('report')->nullable();
            $table->boolean('is_approved')->default(false)->nullable();
            $table->string('approved_by')->nullable();
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
        Schema::dropIfExists('wastages');
    }
}

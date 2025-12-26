<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingPlanPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosting_plan_prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('hosting_plan_id');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->date('valid_from');
            $table->date('valid_to')->nullable();
            $table->uuid('created_by');
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('hosting_plan_id')->references('id')->on('hosting_plans');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hosting_plan_prices');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosting_services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->uuid('hosting_plan_id');
            $table->date('start_date');
            $table->date('renewal_date');
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->string('status');
            $table->timestamp('cancellation_requested_at')->nullable();
            $table->timestamp('cancellation_confirmed_at')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('hosting_plan_id')->references('id')->on('hosting_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hosting_services');
    }
}

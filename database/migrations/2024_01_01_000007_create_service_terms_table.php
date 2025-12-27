<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_terms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('service_type');
            $table->uuid('service_id');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('purchase_price_applied', 10, 2);
            $table->decimal('sale_price_applied', 10, 2);
            $table->decimal('discount_applied', 5, 2)->nullable();
            $table->string('status');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('receipt_number')->nullable();
            $table->date('receipt_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('observations')->nullable();
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();

            $table->index(['service_type', 'service_id']);
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_terms');
    }
}

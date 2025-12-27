<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTldPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tld_prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tld_id');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->date('valid_from');
            $table->date('valid_to')->nullable();
            $table->uuid('created_by');
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('tld_id')->references('id')->on('tlds');
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
        Schema::dropIfExists('tld_prices');
    }
}

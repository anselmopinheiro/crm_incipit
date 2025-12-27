<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('vat')->nullable();
            $table->string('email_billing')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->uuid('reseller_account_id')->nullable();
            $table->string('status');
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('reseller_account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}

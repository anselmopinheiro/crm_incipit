<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->string('domain_name');
            $table->uuid('tld_id');
            $table->date('start_date');
            $table->date('renewal_date');
            $table->string('status');
            $table->timestamp('cancellation_requested_at')->nullable();
            $table->timestamp('cancellation_confirmed_at')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('tld_id')->references('id')->on('tlds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domain_services');
    }
}

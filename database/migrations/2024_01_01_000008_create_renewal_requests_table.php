<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('service_term_id');
            $table->string('recipient_type');
            $table->uuid('recipient_account_id');
            $table->string('token')->unique();
            $table->string('status');
            $table->timestamp('first_sent_at')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('next_send_at')->nullable();
            $table->unsignedInteger('resend_count')->default(0);
            $table->string('response')->nullable();
            $table->text('response_notes')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('service_term_id')->references('id')->on('service_terms');
            $table->foreign('recipient_account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renewal_requests');
    }
}

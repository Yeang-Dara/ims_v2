<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('leave_annual_id');
            $table->integer('status_id')->nullable()->default(1);
            $table->integer('approve_id')->nullable();
            $table->integer('accept_id')->nullable();
            $table->date('date_request');
            $table->date('from_date');
            $table->string('shiftime')->nullable();
            $table->date('to_date');
            $table->string('reason')->nullable();
            $table->string('desc_reject')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
            $table->foreign('leave_annual_id')
                ->references('id')
                ->on('leave_annuals')
                ->onDelete('CASCADE');
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

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
        Schema::create('leave_annuals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('leave_id');
            $table->integer('year_id')->nullable()->default(1);
            $table->integer('credit_leave');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
            $table->foreign('leave_id')
                ->references('id')
                ->on('leaves')
                ->onDelete('CASCADE');
            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_annuals');
    }
};

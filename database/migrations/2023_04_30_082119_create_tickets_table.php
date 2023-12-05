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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id');
            $table->string('atm_id');
            $table->string('model');
            $table->string('terminal_id');
            $table->string('atm_type');
            $table->string('created_time');
            $table->string('issue');
            $table->string('end_time');
            $table->string('atm_down');
            $table->string('diagnosis');
            $table->text('action_taken', 1000);
            $table->string('down_time');
            $table->string('atm_classification');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

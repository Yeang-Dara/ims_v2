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
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id');
            $table->string('sparepart_name');
            $table->integer('quantity');
            $table->integer('quantity_used')->nullable();
            $table->integer('quantity_remain')->nullable();
            $table->string('part_number')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->foreign('model_id')
                ->references('id')
                ->on('terminalmodels')
                ->onDelete('CASCADE');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};

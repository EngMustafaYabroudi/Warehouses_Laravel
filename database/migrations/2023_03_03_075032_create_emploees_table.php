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
        Schema::create('emploees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storehouse_id')->constrained('storehouses')->cascadeOnDelete();
            $table->string('name');
            $table->integer('salary');
            $table->date('birthday');
            $table->date('workstarting');
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emploees');
    }
};

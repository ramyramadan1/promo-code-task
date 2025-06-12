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
        Schema::create('promo_codes', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique(); 
                $table->enum('status', ['active', 'expired']);
                $table->date('expiry_date')->nullable(); 
                $table->integer('max_usage')->nullable();
                $table->integer('usage_times')->default(0);
                $table->enum('promo_type', ['percentage', 'value']);
                $table->float('value');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};

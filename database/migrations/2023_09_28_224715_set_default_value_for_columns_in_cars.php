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
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('price')->default(0)->change();
            $table->integer('shipping_cost')->default(0)->change();
            $table->integer('commission')->default(0)->change();
            $table->string('img')->default(null)->change();
            $table->longText('imgs')->default(null)->change();
            $table->json('specs')->default('{}')->change();
            $table->longText('des')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            //
        });
    }
};
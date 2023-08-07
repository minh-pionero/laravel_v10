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
        Schema::table('products', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->string('preview_source_url')->nullable();
            $table->boolean('is_virtual_product')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('preview_source_url');
            $table->dropColumn('is_virtual_product');
        });
    }
};

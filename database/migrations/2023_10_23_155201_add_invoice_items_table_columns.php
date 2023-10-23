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
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('unit_type')->after('quantity')->nullable();
            $table->after('unit_price', function (Blueprint $table) {
                $table->string('kind')->nullable();
                $table->boolean('text_row')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn([
                'unit_type',
                'kind',
                'text_row',
            ]);
        });
    }
};

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
        Schema::table('customers', function (Blueprint $table) {
            $table->after('user_id', function (Blueprint $table) {
                $table->integer('customer_number');
                $table->string('type')->nullable();
            });
            $table->integer('payment_terms')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'customer_number',
                'type',
            ]);
            $table->integer('payment_terms')->nullable();
        });
    }
};

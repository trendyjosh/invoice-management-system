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
        Schema::table('users', function (Blueprint $table) {
            $table->after('remember_token', function (Blueprint $table) {
                $table->string('company_name')->nullable();
                $table->string('company_number')->nullable();
                $table->string('address_1')->nullable();
                $table->string('address_2')->nullable();
                $table->string('city')->nullable();
                $table->string('county')->nullable();
                $table->string('postcode')->nullable();
                $table->string('phone')->nullable();
                $table->string('bank_name')->nullable();
                $table->integer('bank_acc_no')->nullable();
                $table->integer('bank_sort_code')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'company_number',
                'address_1',
                'address_2',
                'city',
                'county',
                'postcode',
                'phone',
                'bank_name',
                'bank_acc_no',
                'bank_sort_code',
            ]);
        });
    }
};

<?php

use App\Models\User;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('name')->nullable();
            $table->string('company_number')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('bank_acc_no')->nullable();
            $table->integer('bank_sort_code')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        $this->migrateCompaniesFromUsers();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }

    /**
     * Migrate all company data from user attributes into company model.
     */
    private function migrateCompaniesFromUsers(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $newCompany = $user->companies()->create([
                'name' => $user->company_name,
                'company_number' => $user->company_number,
                'address_1' => $user->address_1,
                'address_2' => $user->address_2,
                'city' => $user->city,
                'county' => $user->county,
                'postcode' => $user->postcode,
                'phone' => $user->phone,
                'email' => $user->email,
                'bank_name' => $user->bank_name,
                'bank_acc_no' => $user->bank_acc_no,
                'bank_sort_code' => $user->bank_sort_code,
            ]);

            foreach ($user->invoices as $invoice) {
                $invoice->company_id = $newCompany->id;
                $invoice->save();
            }
        }
    }
};

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'invoice_number_format',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the invoices for the user.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the customers for the user.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Format output of sort code to 'xx-xx-xx'.
     */
    public function getSortCode(): string
    {
        return wordwrap($this->bank_sort_code,  2, '-', true);
    }

    /**
     * Return stats of total customers and invoices for current user.
     */
    public static function getDashboardData(): array
    {
        $statArr = [
            'customers' => [
                'title' => 'Customers',
                'value' => 4,
            ],
            'invoices' => [
                'title' => 'Invoices',
                'value' => 2,
            ],
            'paid' => [
                'title' => 'Paid',
                'value' => 120,
                'description' => 'Total: £9,000',
            ],
            'overdue' => [
                'title' => 'Overdue',
                'value' => 50,
                'description' => 'Total: £1,500',
            ],
        ];

        $chartArr = [
            'invoiceDates' => [
                'labels' => ["Jan", "Feb", "Mar", "Apr", "May"],
                'data' => [15, 20, 25, 35, 20],
            ],
            'invoiceStates' => [
                'labels' => ["Paid", "Outstanding", "Unset"],
                'data' => [20, 20, 15],
            ],
        ];

        return [
            'stats' => $statArr,
            'charts' => $chartArr,
        ];
    }
}

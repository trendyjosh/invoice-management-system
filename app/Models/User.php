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
    public function getDashboardData(): array
    {
        $totalCustomers = $this->customers->count();
        $totalInvoices = $this->invoices->count();
        $paidInvoiceCost = 0;
        $paidInvoices = 0;
        $overdueInvoiceCost = 0;
        $overdueInvoices = 0;

        foreach ($this->invoices as $invoice) {
            if ($invoice->paid) {
                $paidInvoices++;
                $paidInvoiceCost += $invoice->getTotal(false);
            } else {
                $overdueInvoices++;
                $overdueInvoiceCost += $invoice->getTotal(false);
            }
        }

        $outstandingInvoices = $totalInvoices - ($paidInvoices + $overdueInvoices);

        $statArr = [
            'customers' => [
                'title' => 'Customers',
                'value' => $totalCustomers,
            ],
            'invoices' => [
                'title' => 'Invoices',
                'value' => $totalInvoices,
            ],
            'paid' => [
                'title' => 'Paid',
                'value' => $paidInvoices,
                'description' => 'Total: £' . number_format($paidInvoiceCost, 2),
            ],
            'overdue' => [
                'title' => 'Overdue',
                'value' => $overdueInvoices,
                'description' => 'Total: £' . number_format($overdueInvoiceCost, 2),
            ],
        ];

        $chartArr = [
            'invoiceDates' => [
                'labels' => ["Jan", "Feb", "Mar", "Apr", "May"],
                'data' => [15, 20, 25, 35, 20],
            ],
            'invoiceStates' => [
                'labels' => ["Paid", "Outstanding", "Overdue"],
                'data' => [$paidInvoices, $outstandingInvoices, $overdueInvoices],
            ],
        ];

        return [
            'stats' => $statArr,
            'charts' => $chartArr,
        ];
    }
}

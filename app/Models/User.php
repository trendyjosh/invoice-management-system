<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
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
        $outstandingInvoices = 0;

        foreach ($this->invoices as $invoice) {
            switch ($invoice->status) {
                case 'paid':
                    $paidInvoices++;
                    $paidInvoiceCost += $invoice->getTotal(false);
                    break;
                case 'overdue':
                    $overdueInvoices++;
                    $overdueInvoiceCost += $invoice->getTotal(false);
                    break;

                default:
                    $outstandingInvoices++;
                    break;
            }
        }

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

        $months = $this->getInvoiceMonthTotals();

        $chartArr = [
            'invoiceDates' => [
                'labels' => array_keys($months),
                'data' => array_values($months),
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

    /**
     * Get invoice totals for previous months up to the provided limit.
     */
    protected function getInvoiceMonthTotals(int $monthLimit = 6): array
    {
        $months = [];

        // Loop through previous months
        $dt = new Carbon();
        $dt->subMonths($monthLimit);
        for ($i = 0; $i <= $monthLimit; $i++) {
            // Add month count
            $monthString = $dt->shortEnglishMonth;
            $months[$monthString] = 0;

            // Count invoices that month
            foreach ($this->invoices as $invoice) {
                $invoiceDate = Carbon::parse($invoice->date);
                if ($dt->isSameMonth($invoiceDate)) {
                    $months[$monthString]++;
                }
            }

            // Check previous month
            $dt->addMonth();
        }

        return $months;
    }

    /**
     * Get invoice totals for previous months up to the provided limit.
     */
    protected function getInvoiceStatesTotals(int $monthLimit = 6): array
    {
        $months = [];

        // Loop through previous months
        $dt = new Carbon();
        $dt->subMonths($monthLimit);
        for ($i = 0; $i < $monthLimit; $i++) {
            // Add month count
            $monthString = $dt->shortEnglishMonth;
            $months[$monthString] = 0;

            // Count invoices that month
            foreach ($this->invoices as $invoice) {
                $invoiceDate = Carbon::parse($invoice->date);
                if ($dt->isSameMonth($invoiceDate)) {
                    $months[$monthString]++;
                }
            }

            // Check previous month
            $dt->addMonth();
        }

        return $months;
    }

    /**
     * Sort invoices relationship using sort filters from request.
     */
    public function getSortedInvoices(array $formFields, int $paginateLimit): array
    {
        // Get order by direction
        $orderDir = 'asc';
        if (isset($formFields['asc'])) {
            $orderDir = $formFields['asc'] ? 'asc' : 'desc';
        }

        // Get order by column
        $sortKey = $formFields['sort'] ?? 'id';
        switch ($sortKey) {
            case 'customer':
                $orderKey = 'customer_id';
                break;
            case 'id':
            case 'number':
            case 'date':
            case 'due_date':
            case 'status':
                $orderKey = $sortKey;
                break;
            default:
                $orderKey = 'id';
                break;
        }

        // Apply sorting rules
        $invoices = $this->invoices()->orderBy($orderKey, $orderDir)->paginate($paginateLimit);

        return [
            $invoices,
            $sortKey,
            $orderDir,
        ];
    }
}

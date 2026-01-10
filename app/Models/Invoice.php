<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_number',
        'user_id',
        'customer_id',
        'date',
        'due_date',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }

    /**
     * Get the user that owns the invoice.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the invoice items for the invoice.
     */
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the customer that owns the invoice.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the total cost of the invoice items.
     */
    public function getInvoiceNumber(): string
    {
        // Default invoice number format
        $invoiceNumber = $this->invoice_number;

        if ($this->user->invoice_number_format == 1) {
            // Customer-based invoice number format
            $invoiceNumber = str_pad($this->customer->id, 2, '0', STR_PAD_LEFT);
            $invoiceNumber .= '-';
            $invoiceNumber .= str_pad($this->invoice_number, 3, '0', STR_PAD_LEFT);
        }

        return $invoiceNumber;
    }

    /**
     * Determine if the user is an administrator.
     */
    protected function invoiceNumber(): Attribute
    {
        return new Attribute(
            get: function (string $value) {
                // Default invoice number format
                $invoiceNumber = $value;

                if ($this->user->invoice_number_format == 1) {
                    // Customer-based invoice number format
                    $invoiceNumber = str_pad($this->customer->id, 2, '0', STR_PAD_LEFT);
                    $invoiceNumber .= '-';
                    $invoiceNumber .= str_pad($value, 3, '0', STR_PAD_LEFT);
                }

                return $invoiceNumber;
            }
        );
    }

    /**
     * Get the total cost of the invoice items.
     */
    public function getTotal(bool $formatted = true): string
    {
        $total = 0;
        foreach ($this->invoiceItems as $invoiceItem) {
            $total += $invoiceItem->getAmount();
        }
        return $formatted ? number_format($total, 2) : $total;
    }

    /**
     * Get the formatted date for this invoice.
     */
    public function getDateString(): string
    {
        $date = Carbon::createFromFormat('Y-m-d', $this->date);
        return $date->format('d/m/Y');
    }

    /**
     * Get the formatted due date for this invoice.
     */
    public function getDueDateString(): string
    {
        $date = Carbon::createFromFormat('Y-m-d', $this->due_date);
        return $date->format('d/m/Y');
    }

    /**
     * Calculate the due date for this invoice.
     */
    public static function calculateDueDate(string $date, Customer $customer): Carbon
    {
        $dueDate = new Carbon($date);

        // Add customer payment terms (integer day value) to get due date
        $dueDate->addDays($customer->payment_terms);

        return $dueDate;
    }

    /**
     * Print out the invoice as a pdf.
     */
    public function printPdf(): Response
    {
        $invoicePdf = Pdf::loadView('pdf.invoice', ['invoice' => $this]);
        return $invoicePdf->stream('invoice_' . $this->invoice_number . '.pdf');
    }
}

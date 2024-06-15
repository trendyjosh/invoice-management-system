<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
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
        'date',
        'due_date',
    ];

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
    public function getTotal(): string
    {
        $total = 0;
        foreach ($this->invoiceItems as $invoiceItem) {
            $total += $invoiceItem->getAmount();
        }
        return number_format($total, 2);
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
     * Print out the invoice as a pdf.
     */
    public function printPdf(): Response
    {
        $invoicePdf = Pdf::loadView('pdf.invoice', ['invoice' => $this]);
        return $invoicePdf->stream('invoice_' . $this->invoice_number . '.pdf');
    }

    /**
     * Generate the invoice as a pdf and save to temp directory.
     */
    public function createPdf(): string
    {
        $invoicePdf = Pdf::loadView('pdf.invoice', ['invoice' => $this]);

        $filename = 'invoice_' . $this->invoice_number . '.pdf';
        $path = 'invoices/' . $filename;

        $invoicePdf->save($path, 'temp');

        return $path;
    }
}

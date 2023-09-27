<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_date',
        'invoice_number',
        'accountingtype',
        'sumdomestic',
        'taxdomestic',
        'total_sum_domestic',
        'sum',
        'sum_received',
        'total_sum',
        'tax',
        'tax_rate',
        'currency',
        'currency_rate_value',
        'deadline',
        'disable_bookkeeping',
        'invoice_fee',
        'rounding',
        'state',
        'type',
        'customer_number',
        'receiver_org_number',
        'name',
        'contact_name',
        'receiver_email',
        'is_foreign',
        'language',
        'receiver_tax_registration_number',
        'type',
        'delay_interest',
        'delivery_terms',
        'payment_terms',
        'receiver_street1',
        'receiver_street2',
        'receiver_postalcode',
        'receiver_city',
        'receiver_country',
        'country_iso2',
        'country_subdivision',
        'sender_street1',
        'sender_street2',
        'sender_postalcode',
        'sender_city',
        'sender_country',
        'sender_company_name',
        'sender_email',
        'sender_foreign_payment_method_key',
        'sender_foreign_payment_method_primary_label',
        'sender_foreign_payment_method_primary_value',
        'sender_foreign_payment_method_secondary_label',
        'sender_foreign_payment_method_secondary_value',
        'sender_payment_method_key',
        'sender_payment_method_primary_label',
        'sender_payment_method_primary_value',
        'sender_payment_method_secondary_label',
        'sender_payment_method_secondary_value',
        'sender_org_number',
        'phone',
        'reference_name',
        'sender_tax_registration_number',
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
}

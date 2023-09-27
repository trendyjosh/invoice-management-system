<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_number',
        'name',
        'type',
        'organisation_number',
        'vat_number',
        'street',
        'street_2',
        'postal_code',
        'city',
        'contact',
        'email',
        'phone',
        'language',
        'payment_terms',
        'delivery_terms',
        'delay_interest',
        'country',
        'country_iso2',
        'country_subdivision_code',
        'send_to_emails',
    ];

    /**
     * Get the user that owns the customer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the invoices for the customer.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}

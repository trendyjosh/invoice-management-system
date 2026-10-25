<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_number',
        'address_1',
        'address_2',
        'city',
        'county',
        'postcode',
        'phone',
        'email',
        'bank_name',
        'bank_acc_no',
        'bank_sort_code',
        'status',
    ];

    /**
     * Get the user that owns the company.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the invoices for the company.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Format output of sort code to 'xx-xx-xx'.
     */
    public function getSortCode(): string
    {
        return wordwrap($this->bank_sort_code,  2, '-', true);
    }
}

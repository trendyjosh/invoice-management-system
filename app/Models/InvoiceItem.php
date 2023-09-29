<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'description',
        'quantity',
        'unit_price',
    ];

    /**
     * Get the invoice that owns the invoice item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}

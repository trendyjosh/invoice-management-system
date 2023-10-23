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
     * All of the relationships to be touched.
     */
    protected $touches = ['invoice'];

    /**
     * Get the invoice that owns the invoice item.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the total cost of this invoice item.
     */
    public function getAmount(): float
    {
        return $this->quantity * $this->unit_price;
    }
}

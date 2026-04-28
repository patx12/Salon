<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'amount',
        'payment_method',
        'status',
        'reference_number',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'gcash'        => 'GCash',
            'bank_transfer'=> 'Bank Transfer',
            'card'         => 'Card',
            default        => 'Cash',
        };
    }
}

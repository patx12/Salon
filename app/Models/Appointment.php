<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'service_id',
        'appointment_date',
        'notes',
        'status',
        'total_price',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'total_price'      => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'confirmed'  => 'success',
            'completed'  => 'primary',
            'cancelled'  => 'danger',
            default      => 'warning',
        };
    }
}

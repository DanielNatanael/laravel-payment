<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

public function payment()
{
    return $this->hasOne(Payment::class);
}


    use HasFactory;

    protected $fillable = [
        'booking_code', 
        'customer_name', 
        'customer_email', 
        'customer_phone',
        'visit_date', 
        'visit_time', 
        'total_amount', 
        'status', 
        'payment_status', 
        'notes'
    ];

    protected $casts = [
        'visit_date' => 'date',
        'visit_time' => 'datetime:H:i',
        'total_amount' => 'decimal:2',
    ];

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            $booking->booking_code = 'PLG-' . strtoupper(uniqid());
        });
    }
}
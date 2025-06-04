<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'total_amount',
        'payment_status', // ENUM: 'pending', 'paid', 'failed', 'refunded'
        'payment_gateway_reference', // ID transaksi dari payment gateway
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke Enrollment jika satu order menghasilkan satu enrollment (sederhana)
    // public function enrollment(): HasOne
    // {
    //     return $this->hasOne(Enrollment::class);
    // }
}

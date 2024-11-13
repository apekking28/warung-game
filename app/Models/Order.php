<?php

namespace App\Models;

use App\Traits\AuditedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, AuditedBy, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'payment_status',
        'order_date',
    ];

    // Relasi ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke games melalui order items
    public function games()
    {
        return $this->belongsToMany(Game::class, 'order_items')
            ->withPivot('quantity', 'unit_price', 'subtotal');
    }
}
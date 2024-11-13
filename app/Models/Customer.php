<?php

namespace App\Models;

use App\Traits\AuditedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, AuditedBy, SoftDeletes;

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
<?php

namespace App\Models;

use App\Traits\AuditedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, AuditedBy, SoftDeletes;

    protected $table = 'games';

    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'description',
        'price',
        // 'stock',
        'release_date',
        'image',
        'publisher_id',
        'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'release_date' => 'date'
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'game_categories');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, AuditedBy, SoftDeletes;

    protected $table = 'categories';
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];


    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_categories');
    }
}

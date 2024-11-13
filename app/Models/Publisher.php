<?php

namespace App\Models;

use App\Traits\AuditedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use HasFactory, AuditedBy, SoftDeletes;

    protected $table = 'publishers';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'slug',
        'description',
        'logo',
        'country',
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}

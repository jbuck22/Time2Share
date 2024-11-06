<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'deadline',
        'owner_id',
        'loaner_id',
        'loaned_out',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function loaner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'loaner_id');
    }

    protected static function booted()
    {
        static::saving(function($product){
            if(!$product->loaned_out){
                $product->loaner_id = null;
            }
        });
    }
}

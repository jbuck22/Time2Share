<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\RedirectResponse;

class Review extends Model
{
    use HasFactory;

    /**
 * The attributes that are mass assignable.
 *
 * @var array<int, string>
 */

    protected $fillable =[
    'title',
    'description',
    'product_id',
    'reviewer_id',
    'reviewLoaner_id',
    'rating'
    ];

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewloaner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewLoaner_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


}

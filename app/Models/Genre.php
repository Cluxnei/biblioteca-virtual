<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static self create(array $array)
 */
class Genre extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name'];

    public function ebooks(): BelongsToMany
    {
        return $this->belongsToMany(Ebook::class, 'ebooks_genres', 'genre_id', 'ebook_id')
            ->withTimestamps()->withPivot('deleted_at');
    }
}

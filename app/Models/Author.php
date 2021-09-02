<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes, HasFactory;

    public function ebooks(): BelongsToMany
    {
        return $this->belongsToMany(Ebook::class, 'ebooks_authors', 'author_id', 'ebook_id')
            ->withTimestamps()->withPivot('deleted_at');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Ebook extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'ebooks';

    protected $fillable = [
        'title',
        'year',
        'description',
        'front_cover_image',
        'pdf_path',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'ebooks_authors', 'ebook_id', 'author_id')
            ->withTimestamps()->withPivot('deleted_at');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'ebooks_genres', 'ebook_id', 'genre_id')
            ->withTimestamps()->withPivot('deleted_at');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'ebooks_categories', 'ebook_id', 'category_id')
            ->withTimestamps()->withPivot('deleted_at');
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'ebooks_comments', 'ebook_id', 'comment_id')
            ->withTimestamps()->withPivot('deleted_at');
    }

    public function getShortDescriptionAttribute(): string
    {
        return substr($this->getOriginal('description'), 0, 40) . '...';
    }

    public function getShortTitleAttribute(): string
    {
        return substr($this->getOriginal('title'), 0, 30) . '...';
    }

    public function getPhotoUrlAttribute(): string
    {
        return Storage::url($this->getOriginal('front_cover_image'));
    }

}

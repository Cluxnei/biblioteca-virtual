<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @method static self create(array $array)
 */
class Ebook extends Model
{

    private const _SHORT_ATTR_LEN = 40;

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
        $len = strlen($this->getOriginal('description'));

        if ($len <= self::_SHORT_ATTR_LEN) {
            return $this->getOriginal('description');
        }

        return substr($this->getOriginal('description'), 0, 40) . '...';
    }

    public function getShortTitleAttribute(): string
    {
        $len = strlen($this->getOriginal('title'));

        if ($len <= self::_SHORT_ATTR_LEN) {
            return $this->getOriginal('title');
        }

        return substr($this->getOriginal('title'), 0, 30) . '...';
    }

    public function getPhotoUrlAttribute(): string
    {
        return Storage::url($this->getOriginal('front_cover_image'));
    }

}

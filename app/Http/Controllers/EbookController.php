<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Genre;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    private const _PER_PAGE = 5;

    private function getEbookRelationships(): array
    {
        return [
            'authors' => static function (BelongsToMany $query) {
                $query->select('authors.id', 'authors.name');
            },
            'genres' => static function (BelongsToMany $query) {
                $query->select('genres.id', 'genres.name');
            },
            'categories' => static function (BelongsToMany $query) {
                $query->select('categories.id', 'categories.name');
            },
            'comments' => static function (BelongsToMany $query) {
                $query->select('comments.id', 'comments.message');
            },
        ];
    }

    public function index(Request $request): Renderable
    {
        $q = $request->get('q');
        if ($q) {
            return $this->searchIndex($q);
        }
        $ebooks = Ebook::with($this->getEbookRelationships())
            ->withCount('comments')
            ->paginate(self::_PER_PAGE)
            ->appends('q', $q);
        return view('ebook.index', compact('ebooks', 'q'));
    }

    private function searchIndex(string $q): Renderable
    {
        $ebooks = Ebook::with($this->getEbookRelationships())
            ->withCount('comments')
            ->where('title', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->orWhere('year', 'like', $q)
            ->orWhereHas('authors', static function (Builder $query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orWhereHas('genres', static function (Builder $query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orWhereHas('categories', static function (Builder $query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orWhereHas('comments', static function (Builder $query) use ($q) {
                $query->where('message', 'like', "%{$q}%");
            })
            ->paginate(self::_PER_PAGE)
            ->appends('q', $q);
        return view('ebook.index', compact('ebooks', 'q'));
    }

    public function create(): Renderable
    {
        $categories = Category::query()->select('id', 'name')->get();
        $authors = Author::query()->select('id', 'name')->get();
        $genres = Genre::query()->select('id', 'name')->get();
        return view('ebook.create', compact('authors', 'genres', 'categories'));
    }
}

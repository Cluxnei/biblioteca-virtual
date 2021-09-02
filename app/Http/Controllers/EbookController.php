<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    private const _PER_PAGE = 5;

    public function index(Request $request): Renderable
    {
        $q = $request->get('q');
        if ($q) {
            return $this->searchIndex($q);
        }
        $ebooks = Ebook::with('authors', 'genres', 'categories', 'comments')
            ->withCount('comments')
            ->paginate(self::_PER_PAGE)
            ->appends('q', $q);
        return view('ebook.index', compact('ebooks', 'q'));
    }

    private function searchIndex(string $q): Renderable
    {
        $ebooks = Ebook::with('authors', 'genres', 'categories', 'comments')
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
}

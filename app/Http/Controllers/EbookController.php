<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEbookRequest;
use App\Models\Author;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Genre;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

    public function store(StoreEbookRequest $request): RedirectResponse
    {
        try {
            $uuid = uniqid(Str::slug(now()->toDateTimeString() . '-'), true);
            $coverName = $this->ebookFileName($uuid, $request->file('cover_file'));
            $pdfName = $this->ebookFileName($uuid, $request->file('pdf_file'));

            $ebook = Ebook::create([
                'title' => $request->input('title'),
                'year' => $request->input('year'),
                'description' => $request->input('description'),
                'front_cover_image' => $request->file('cover_file')->storeAs('covers', $coverName),
                'pdf_path' => $request->file('pdf_file')->storeAs('ebooks', $pdfName),
            ]);

            $ebook->authors()->sync($this->resolveNewEntities(collect($request->input('authors')), 'authors'));
            $ebook->genres()->sync($this->resolveNewEntities(collect($request->input('genres')), 'genres'));
            $ebook->categories()->sync($this->resolveNewEntities(collect($request->input('categories')), 'categories'));

            return redirect()->route('dashboard.ebook.create')->with('success', true);

        } catch (Exception $exception) {
            Log::error($exception);
            return redirect()->route('dashboard.ebook.create')->withInput()->with('success', false);
        }
    }

    private function ebookFileName(string $uuid, UploadedFile $file): string
    {
        $name = Str::slug($file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        return substr("{$uuid}-{$name}.{$extension}", 0, 255);
    }

    private function resolveNewEntity(string $id, string $type): ?string
    {
        switch ($type) {
            case 'authors':
                return Author::create(['name' => substr($id, 1)])->id;
            case 'genres':
                return Genre::create(['name' => substr($id, 1)])->id;
            case 'categories':
                return Category::create(['name' => substr($id, 1)])->id;
        }
        return null;
    }

    private function resolveNewEntities(Collection $collection, string $type): Collection
    {
        return $collection->map(fn(string $id) => $this->existsId($id) ? $id : $this->resolveNewEntity($id, $type))
            ->filter(static fn(?string $id) => null !== $id);
    }

    private function existsId(string $id): bool
    {
        return $id[0] !== '|';
    }

}

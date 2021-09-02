<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    private const _PER_PAGE = 6;

    public function index(): Renderable
    {
        $ebooks = Ebook::with('genres', 'authors', 'categories')
            ->withCount('comments')->paginate(self::_PER_PAGE);
        return view('welcome', compact('ebooks'));
    }

    public function show()
    {
    }
}

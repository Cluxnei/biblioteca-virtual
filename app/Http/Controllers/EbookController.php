<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Contracts\Support\Renderable;

class EbookController extends Controller
{
    public function index(): Renderable
    {
        $ebooks = Ebook::with('authors', 'genres', 'categories', 'comments')->paginate(5);
        return view('ebook.index', compact('ebooks'));
    }
}

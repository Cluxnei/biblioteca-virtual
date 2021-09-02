<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Ebook;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'Yara Cluxnei',
            'email' => 'yara@cluxnei.com',
            'password' => Hash::make('yara@123'),
            'is_admin' => 1,
        ]);

        Ebook::factory()
            ->has(Author::factory()->count(3), 'authors')
            ->has(Genre::factory()->count(3), 'genres')
            ->has(Comment::factory()->count(3), 'comments')
            ->has(Category::factory()->count(3), 'categories')
            ->count(1000)
            ->create();

        Ebook::factory()->count(5)->create();

        Author::factory()->count(500)->create();
        Genre::factory()->count(500)->create();
        Comment::factory()->count(500)->create();
        Category::factory()->count(500)->create();

    }
}

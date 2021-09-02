<?php

use App\Models\Ebook;
use App\Models\Genre;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ebooks_genres', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ebook::class, 'ebook_id');
            $table->foreignIdFor(Genre::class, 'genre_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('ebooks_genres', function (Blueprint $table) {
            $table->dropForeign('ebook_id');
            $table->dropForeign('genre_id');
        });
        Schema::dropIfExists('ebooks_genres');
    }
}

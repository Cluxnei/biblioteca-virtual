<?php

use App\Models\Author;
use App\Models\Ebook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ebooks_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ebook::class, 'ebook_id');
            $table->foreignIdFor(Author::class, 'author_id');
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
        Schema::table('ebooks_authors', function (Blueprint $table) {
            $table->dropForeign('ebook_id');
            $table->dropForeign('author_id');
        });
        Schema::dropIfExists('ebooks_authors');
    }
}

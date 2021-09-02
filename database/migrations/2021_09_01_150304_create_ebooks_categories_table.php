<?php

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ebooks_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ebook::class, 'ebook_id');
            $table->foreignIdFor(Category::class, 'category_id');
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
        Schema::table('ebooks_categories', function (Blueprint $table) {
            $table->dropForeign('ebook_id');
            $table->dropForeign('category_id');
        });
        Schema::dropIfExists('ebooks_categories');
    }
}

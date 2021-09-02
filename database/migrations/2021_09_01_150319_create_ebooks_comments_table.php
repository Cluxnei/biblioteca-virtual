<?php

use App\Models\Comment;
use App\Models\Ebook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ebooks_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ebook::class, 'ebook_id');
            $table->foreignIdFor(Comment::class, 'comment_id');
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
        Schema::table('ebooks_comments', function (Blueprint $table) {
            $table->dropForeign('ebook_id');
            $table->dropForeign('comment_id');
        });
        Schema::dropIfExists('ebooks_comments');
    }
}

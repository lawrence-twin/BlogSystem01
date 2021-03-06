<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Comment;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
	* 50件の投稿を作成して、各投稿に２つのコメントを作成する。
	*/
        factory(Post::class, 50)
	    ->create()
	    ->each(function ($post) {
	    	$comments = factory(App\Comment::class, 2)->make();
		$post->comments()->saveMany($comments);
	    });
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
	protected $fillable = array('post_id');

	//コメントを登録する
	public function store(Request $request)
	{
		$params = $request->validate([
			'post_id' => 'required|exists:posts,id',
			'body' => 'required|max:2000',
		]);
		
		$post = Post::findOrFail($params['post_id']);
		$post->comments()->create($params);

		return redirect()->route('posts.show', ['post' => $post]);
	}
    
	//投稿画面にもどる	
	public function show($post_id)
	{
		$post = Post::findOrFail($post_id);

		return redirect()->route('posts.show', ['post' => $post]);
	}


	public function edit($id)
	{
		$comment = Comment::findOrFail($id);

		return view('comments.edit', [
			'comment' => $comment,
		]);
	}

	public function update($id)
	{
		$params = $request->validate([
			'body' => 'required|max:2000',
		]);

		$comment = Comment::findOrFail($id);
		$comment->fill($params)->save();

		return redirect()->route('posts.show', ['post' => $post]);

	}

	//コメントを削除する
	public function destroy($id)
	{
		$comment = Comment::findOrFail($id);

		\DB::transaction(function () use ($comment) {
			$comment->comments()->delete();
		});

		return redirect()->route('top');
	}
}



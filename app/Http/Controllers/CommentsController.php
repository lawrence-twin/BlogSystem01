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
	public function show($comment_id)
	{
		$comment = Comment::findOrFail($comment_id);
		//getのみでは単一でないため、firstメソッドを利用
		$post = $comment->post()->get()->first();
		return redirect()->route('posts.show', ['post' => $post]);
	}

	//コメント編集画面に移動
	public function edit($id)
	{
		$comment = Comment::findOrFail($id);

		return view('comments.edit', [
			'comment' => $comment,
		]);
	}

	//コメントを更新する
	public function update($id, Request $request)
	{
		$params = $request->validate([
			'body' => 'required|max:2000',
		]);

		$comment = Comment::findOrFail($id);
		$comment->fill($params)->save();

		//getのみでは単一でないため、firstメソッドを利用
		$post = $comment->post()->get()->first();
		return redirect()->route('posts.show', ['post' => $post]);

	}

	//コメントを削除する
	public function destroy($comment_id)
	{
		$comment = Comment::findOrFail($comment_id);

		\DB::transaction(function () use ($comment) {
			$comment->delete();
		});

		//getのみでは単一でないため、firstメソッドを利用
		$post = $comment->post()->get()->first();
		return redirect()->route('posts.show', ['post' => $post]);
	}
}



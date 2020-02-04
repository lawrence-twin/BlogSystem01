<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
		//SQLチューニング(Commentsの取得方法を改善)
		//$posts = Post::orderBy('created_at', 'desc')->paginate(10);
		$posts = Post::with(['comments'])->orderBy('created_at', 'desc')->paginate(10);
		
		return view('posts.index', ['posts' => $posts]);
    }

	public function create(){
		return view('posts.create');
	}

	public function store(Request $request)
	{

		//image_urlに設定を入れるため一旦初期化
		$params = array('title'=>"", 'body'=>"", 'image_url'=>"");
		$params = $request->validate([
			'title' => 'required|max:50',
			'body' => 'required|max:2000',
		]);

		if ($request->hasFile('image_url'))
		{
			$time = time();		//暫定的な日時で画像ファイルを保存する
								//余裕があったらユーザIDもつける
			$image_url = $request->image_url->storeAs(
				'public/post_images', 
				$time . '.jpg'
			);
			$params['image_url'] = $image_url;
		}
		Post::create($params);

		return redirect()->route('top');
	}
	
	public function show($post_id)
	{
		$post = Post::findOrFail($post_id);

		return view('posts.show', [
			'post' => $post,
			'image_url' => str_replace('public/', 'storage/', $post->image_url),
		]);
	}

    public function edit($post_id)
	{
		$post = Post::findOrFail($post_id);

		return view('posts.edit', [
			'post' => $post,
		]);
	}

	public function update($post_id, Request $request)
	{
		//image_urlに設定を入れるため一旦初期化
		$params = array('title'=>"", 'body'=>"", 'image_url'=>"");
		$params = $request->validate([
			'title' => 'required|max:50',
			'body' => 'required|max:2000',
		]);

		if ($request->hasFile('image_url'))
		{
			$time = time();		//暫定的な日時で画像ファイルを保存する
								//余裕があったらユーザIDもつける
			$image_url = $request->image_url->storeAs(
				'public/post_images', 
				$time . '.jpg'
			);
			$params['image_url'] = $image_url;
		}
		
		$post = Post::findOrFail($post_id);
		$post->fill($params)->save();

		return redirect()->route('posts.show', ['post' => $post]);
	}

	public function destroy($post_id)
	{
		$post = Post::findOrFail($post_id);
    
		\DB::transaction(function () use ($post) {
			$post->comments()->delete();
			$post->delete();
		});
    
		return redirect()->route('top');
	}

}

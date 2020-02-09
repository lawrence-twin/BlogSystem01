<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use App\Image;

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
		$params = array('user_id'=>0,'title'=>"", 'body'=>"");
		$params = $request->validate([
			'title' => 'required|max:50',
			'body' => 'required|max:2000',
			'images.*' => 'image|mimes:jpeg,bmp,png',
		]);

		$params['user_id'] = Auth::id();
		
		//投稿の保存
		$post = Post::create($params);

		//画像の保存機能
		if ($request->hasfile('images'))
		{
			foreach ($request->file('images') as $index=> $img)
			{
			
				$ext = $img->guessExtension();
				$time = time();
				$filename = "{$params['user_id']}_{$index}_{$time}.{$ext}";
				$path = $img->storeAs('public/post_images', $filename);
	
				//紐付けられた画像の投稿
				$post->images()->create(['path'=> $path]);
			}
		}
		return redirect()->route('top');
	}
	
	public function show($post_id)
	{
		
		$user = Auth::user();
		$post = Post::findOrFail($post_id);

		return view('posts.show', [
			'post' => $post,
			'user' => $user
		]);
	}

    public function edit($post_id)
	{
		$user = Auth::user();
		$post = Post::findOrFail($post_id);

		//投稿者以外はページ遷移できないように修正
		if ($user->id == $post->user_id)
		{
			return view('posts.edit', [
				'post' => $post,
				'user' => $user
			]);
		} else {

			return redirect()->route('top');
		}
	}

	public function update($post_id, Request $request)
	{
		//image_urlに設定を入れるため一旦初期化
		$params = array('user_id'=>0,'title'=>"", 'body'=>"");
		$params = $request->validate([
			'title' => 'required|max:50',
			'body' => 'required|max:2000',
			'images.*' => 'image|mimes:jpeg,bmp,png',
		]);

		$params['user_id'] = Auth::id();

		$post = Post::findOrFail($post_id);
		$post->fill($params)->save();
		
		//画像の保存機能
		if ($request->hasfile('images'))
		{
			\DB::transaction(function () use ($post) {
				$post->images()->delete();
			});
			foreach ($request->file('images') as $index=> $img)
			{
				$ext = $img->guessExtension();
				$time = time();
				$filename = "{$params['user_id']}_{$index}_{$time}.{$ext}";
				$path = $img->storeAs('public/post_images', $filename);
	
				//紐付けられた画像の投稿
				$post->images()->create(['path'=> $path]);
			}
		}

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

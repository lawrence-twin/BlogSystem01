@extends('layout')

@section('content')
	<div class="container= mt-4">
		@auth
		<div class="mb-4 text-right">
			<a href="{{ route('posts.create') }}" class="btn btn-primary">
				投稿を新規作成
			</a>
		</div>
		@endauth
		<?php $newlineflg = TRUE; ?>
		@foreach ($posts as $post)
			@if ($newlineflg)
				<div class="row">
				<?php $newlineflg = FALSE; ?>
			@else
				<?php $newlineflg = TRUE; ?>
			@endif
			<div class="card w-25 d-inline-block m-5">
			@if ($post->images()->first())
				<a href="{{ route('posts.show', ['post' => $post]) }}">
					<img class="card-img-top" src ="/{{ str_replace('public/','storage/', $post->images()->first()->path), }}">
				</a>
            @else
				<a href="{{ route('posts.show', ['post' => $post]) }}">
					<img class="card-img-top" src ="storage/default/unnamed.png">
				</a>
			@endif
				<div class="card-header">
					<a href="{{ route('posts.show', ['post' => $post]) }}">
					タイトル：{{ $post->title }}
					</a>
				</div>
				<div class="card-body">
					<p class="card-text">
						{!! nl2br(e(Str::limit($post->body, 200))) !!}
                	</p>
				</div>
				<a class="card-link text-right" href="{{ route('posts.show', ['post' => $post]) }}">
					続きを読む
				</a>
				<div class="card-footer">
					<span class="mr-2">
						投稿日時:{{ $post->created_at->format('Y.m.d') }}
						投 稿 者:{{ $user->name) }}
					</span>
					@if ($post->comments->count())
						<span class="badge badge-primary">
							コメント {{ $post->comments->count() }}件
						</span>
					@endif
				</div>
			</div>
			@if ($newlineflg)
				</div>
			@endif
		@endforeach
		@if (!$newlineflg)
			</div>
		@endif
		<div class="d-flex justify-content-center mb-5">
			{{ $posts->links() }}
		</div>
	</div>
@endsection


@extends('layout')

@section('content')
	<div class="container mt-4">
		<div class="border p-4">
			<h1 class="h5 mb-4">
				投稿の編集
			</h1>

			<form method="POST" action="{{ route('posts.update', ['post' => $post]) }}" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<fieldset class="mb-4">
					<div class="form-group">
						<label for="title">>
							タイトル
						</label>
						<input
							id="title"
							name="title"
							class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"

							value="{{ old('title') ?: $post->title}}"
							type="text"
						>
						@if ($errors->has('title'))
							<div class="invalid-feedback">
								{{ $errors->first('title') }}
							</div>
						@endif
					</div>

					<div class="form-group">
						<label for="body">
							本文
						</label>

						<textarea
							id="body"
							name="body"
							class="form-cotrol {{ $errors->has('body') ? 'is-invalid' : ''}}"
							rows="4"
						>{{ old('body') ?: $post->body }}</textarea>
						@if ($errors->has('body'))
							<div class="invalid-feedback">
								{{ $errors->first('body') }}
							</div>
						@endif
					</div>

					<div class="form-image_url">
   						複数可：<input type="file" class=form-control" name="images[]" multiple> 
					</div>
					
					<div class="mt-5">
						<a class="btn btn-sedondary" href="{{ route('posts.show', ['post' => $post]) }}">
							キャンセル
						</a>
						<form
							style="display: inline-block;"
							method="POST"
							action"{{ route('posts.update', ['post' => $post]) }}">
							@csrf
							@method('PATCH')
							<button type="submit" class="btn btn-primary">更新する</button>
						</form>
						<form
							style="display: inline-block;"
							method="POST"
 		                	action="{{ route('posts.destroy', ['post' => $post]) }}">
							@csrf
							@method('DELETE')
							<button class="btn btn-danger">削除する</button>
						</form>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
@endsection


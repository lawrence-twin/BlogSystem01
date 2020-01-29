@extends('layout')

@section('content')
	<div class="container mt-4">
		<div class="border p-4">
			<h1 class="h5 mb-4">
				コメントの編集
			</h1>

			<form method="COMMENT" action="{{ route('comments.update', ['comment' => $comment]) }}">
				@csrf
				@method('PUT')

					<div class="form-group">
						<label for="body">
							本文
						</label>

						<textarea
							id="body"
							name="body"
							class="form-cotrol {{ $errors->has('body') ? 'is-invalid' : ''}}"
							rows="4"
						>{{ old('body') ?: $comment->body }}</textarea>
						@if ($errors->has('body'))
							<div class="invalid-feedback">
								{{ $errors->first('body') }}
							</div>
						@endif
					</div>

					<div class="mt-5">
						<a class="btn btn-sedondary" href="{{ route('comments.show', ['comment' => $comment]) }}">
							キャンセル
						</a>
						<form
							style="display: inline-block;"
							method="COMMENT"
							action"{{ route('comments.update', ['comment' => $comment]) }}">
							@csrf
							@method('PATCH')

							<button type="submit" class="btn btn-primary">
								更新する
							</button>
						</form>
						<form
							style="display: inline-block;"
							method="COMMENT"
 		                	action="{{ route('comments.destroy', ['comment' => $comment]) }}">
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


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">about</div>

                <div class="card-body">
					<h1>概要</h1>
					<p>
						Meu Blogという名前ですが、Meu = ポルトガル語で「私の」という意味です。<br>
						最初はMyBlogという名前にしようとしましたが既にあったので、この名前です。<br>
						正直名前は適当です。<br>
					</p>
					<h1>実装機能</h1>
					<li>記事投稿機能</li>
					<li>記事詳細表示機能</li>
					<li>記事編集機能</li>
					<li>画像投稿機能(複数可能）</li>
					<li>ユーザログイン機能</li>
					<li>ユーザ登録機能</li>
					<li>ページネーション機能</li>
					<li>コメント機能</li>
					<h1>使い方</h1>	
					<li>ログインしなくても、記事参照及びコメントができます。</li>
					<li>コメントは、記事を開いて画面下部に入力ボタンがあります。</li>
					<li>記事投稿する場合は、ユーザ登録・ログイン後に行えます。</li>
					<li>他人の記事を更新できないので、更新できるのは自分の記事だけです。</li>
                    <font size=7></font>
                </div>
				<p>■git Hubリンク</p>
				<a href="https://github.com/lawrence-twin/BlogSystem01">https://github.com/lawrence-twin/BlogSystem01</a>
			</div>
        </div>
    </div>
</div>
@endsection

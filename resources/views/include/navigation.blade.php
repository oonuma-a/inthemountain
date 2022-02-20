<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container px-4 px-lg-5">
		<a class="navbar-brand" href="{{route('shop.index')}}">IN THE MOUNTAIN</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
				<li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('shop.index')}}">Online Shop<br>オンラインショップ</a></li>
				<li class="nav-item"><a class="nav-link" href="#!">About<br>商品について</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sale List<br>商品一覧</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="#!">すべての商品</a></li>
						<li><hr class="dropdown-divider" /></li>
						<li><a class="dropdown-item" href="#!">セール中</a></li>
						<li><a class="dropdown-item" href="#!">新着商品</a></li>
					</ul>
				</li>
				<li class="nav-item"><a class="nav-link" href="{{route('item.create')}}">Sell<br>商品を出品</a></li>
			</ul>
			<form class="d-flex">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('user.index')}}">sign up<br>ユーザー一覧</a></li>
					<li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('user.create')}}">sign up<br>新規登録</a></li>
					<li class="nav-item"><a class="nav-link" href="{{route('auth.index')}}">Login<br>ログイン</a></li>
				</ul>
				<button class="btn btn-outline-dark" type="submit">
					<i class="bi-cart-fill me-1"></i>
					Cart
					<span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
				</button>
			</form>
		</div>
	</div>
</nav>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container px-4 px-lg-5">
		<a class="navbar-brand" href="{{route('shop.index')}}">IN THE MOUNTAIN</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
				<li class="nav-item"><a class="nav-link" aria-current="page" href="{{route('shop.index')}}">Online Shop<br>オンラインショップ</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sale List<br>商品一覧</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="#!">すべての商品</a></li>
						<li><hr class="dropdown-divider" /></li>
						<li><a class="dropdown-item" href="#!">セール中</a></li>
						<li><a class="dropdown-item" href="#!">新着商品</a></li>
					</ul>
				</li>
			</ul>
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
				@guest
				<li class="nav-item"><a class="nav-link" aria-current="page" href="{{route('user.create')}}">register<br>新規登録</a></li>
				<li class="nav-item"><a class="nav-link" href="{{route('auth.index')}}">Login<br>ログイン</a></li>
				@endguest
					@auth
						<li class="nav-item">
							<form class="d-flex" method="get" action="{{route('user.edit')}}" name="editform">
								@csrf
								<input type="hidden" name="user_update_flg" value="1">
								<input type="hidden" name="id" value="{{Auth::id()}}">
								<a class="nav-link" aria-current="page" href="javascript:editform.submit()">update<br>登録情報変更</a>		
							</form>
						</li>	
					<li class="nav-item">
						<form class="d-flex" method="post" action="{{route('auth.index')}}" name="logoutform">
							@csrf
							<input type="hidden" name="logout_flg" value="1">
							<input type="hidden" name="id" value="1">
							<a class="nav-link" aria-current="page" href="javascript:logoutform.submit()">Logout<br>ログアウト</a>
						</form>
					</li>
					@if(Auth::user()->user_authority == 1)
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin menu<br>管理者メニュー</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="#!">管理者メニュー</a></li>
								<li><hr class="dropdown-divider" /></li>
								<li><a class="dropdown-item" href="{{route('user.index')}}">ユーザー一覧</a></li>
								<li><a class="dropdown-item" href="{{route('user.create')}}">管理ユーザー追加</a></li>
								<li><a class="dropdown-item" href="{{route('item.index')}}">商品一覧</a></li>
								<li><a class="dropdown-item" href="{{route('item.create')}}">商品追加</a></li>
							</ul>
						</li>
					@endif
				@endauth
			</ul>
			@auth
				{{Auth::user()->user_name}} 様
			@endauth
			@guest
				ゲスト 様
			@endguest
			<form class="d-flex" action="{{route('shop.cart')}}" method="get" name="cartform">
				@csrf
				<input type="hidden" name="cart_add" value="1">
				<a href="javascript:cartform.submit()" class="btn btn-outline-dark" type="submit">
					<i class="bi-cart-fill me-1"></i>
					Cart
					<span class="badge bg-dark text-white ms-1 rounded-pill">5</span>
				</a>
			</form>
		</div>
	</div>
</nav>
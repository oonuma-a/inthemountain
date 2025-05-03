<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container px-4 px-lg-5">
		<a class="navbar-brand" href="{{route('shop.index')}}">IN THE MOUNTAIN</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sale List<br>商品一覧</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="{{route('shop.index')}}">すべての商品</a></li>
						<li><hr class="dropdown-divider" /></li>
						<li>
							<form action="{{route('shop.index')}}" method="get" name="header_saleform">
								<button type="submit" name="sale_search" value="1" class="dropdown-item">
									セール中の商品
								</button>
							</form>
						</li>
						<li><hr class="dropdown-divider" /></li>
						<form action="{{route('shop.index')}}" method="get" name="header_categoryform">
							@foreach($categories as $category)
								<li>
									<input type="submit" name="category_search" class="dropdown-item" value="{{$category}}">
								</li>
							@endforeach
						</form>
					</ul>
				</li>
			</ul>
			<ul class="navbar-nav mb-2 mb-lg-0 ms-lg-4">
				@guest
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{route('user.create')}}">Register<br>新規登録</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('auth.index')}}">Login<br>ログイン</a>
					</li>
				@endguest
				@auth
					@if(Auth::user()->user_authority == 1)
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin Manu<br>管理メニュー</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="{{route('user.index')}}">ユーザー一覧</a></li>
								<li><a class="dropdown-item" href="{{route('user.create')}}">ユーザー追加</a></li>
								<li><a class="dropdown-item" href="{{route('item.index')}}">商品一覧</a></li>
								<li><a class="dropdown-item" href="{{route('item.create')}}">商品追加</a></li>
							</li>
						</ul>
					</li>
					@endif
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">User Manu<br>ユーザーメニュー</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li>
								<a class="dropdown-item" aria-current="page" href="{{route('user.edit', ['id' => Auth::user()->id])}}">
									登録情報変更
								</a>
							</li>
							<li>
								<form class="d-flex" method="post" action="{{route('auth.logout')}}" name="header_logoutform">
									@csrf
									<input type="submit" class="dropdown-item" aria-current="page" value="ログアウト">
								</form>
							</li>
						</ul>
					</li>
				@endauth
			</ul>
			<div class="nav-cart">
				<p class="user-name">
					@auth
						{{Auth::user()->user_name}} 様
					@endauth
					@guest
						ゲスト 様
					@endguest
				</p>
				<a href="{{route('cart.index')}}" class="d-flex cart-a">
					@csrf
						<div class="cart-btn btn-outline-dark">
							<i class="bi-cart-fill me-1"></i>
							Cart
							<span class="badge bg-dark text-white ms-1 rounded-pill">
								@if(null != session()->get('cart_data'))
								<?php
									$itemQuantitySum = 0;
									foreach(session()->get('cart_data') as $cart_quantity){
										$itemQuantitySum = $itemQuantitySum + $cart_quantity['cart_item_number'];
									}
									echo $itemQuantitySum;
								?>
								@else
									0
								@endif
							</span>
						</div>
				</a>
			</div>
		</div>
	</div>
</nav>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container px-4 px-lg-5">
		<a class="navbar-brand" href="{{route('shop.index')}}">IN THE MOUNTAIN</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
				<li class="nav-item"><a class="nav-link" aria-current="page" href="{{route('shop.index')}}">Online Shop<br>ショップ</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sale List<br>商品一覧</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="{{route('shop.index')}}">すべての商品</a></li>
						<li><hr class="dropdown-divider" /></li>
						<li>
							<form action="{{route('shop.index')}}" method="get" name="saleform">
								@csrf
								<input type="hidden" name="sale_search" value="1">
								<a class="dropdown-item" href="javascript:saleform.submit()">セール中の商品</a>
							</form>
						</li>
						<form action="{{route('shop.index')}}" method="get">
							@csrf
							<input type="hidden" name="category_search" value="1">
							<select name="category_search"  class="dropdown-item" onchange="submit()">
								<li><option class="dropdown-item bg-white">カテゴリー</option></li>
								<li><option class="dropdown-item bg-white" value="アウター">アウター</option></li>
								<li><option class="dropdown-item bg-white" value="インナー">インナー</option></li>
								<li><option class="dropdown-item bg-white" value="レインウェア">レインウェア</option></li>
								<li><option class="dropdown-item bg-white" value="パンツ">パンツ</option></li>
								<li><option class="dropdown-item bg-white" value="ハイキングシューズ">ハイキングシューズ</option></li>
								<li><option class="dropdown-item bg-white" value="トレッキングシューズ">トレッキングシューズ</option></li>
								<li><option class="dropdown-item bg-white" value="ブーツ">ブーツ</option></li>
								<li><option class="dropdown-item bg-white" value="スニーカー">スニーカー</option></li>
								<li><option class="dropdown-item bg-white" value="バッグ/リュック">バッグ/リュック</option></li>
								<li><option class="dropdown-item bg-white" value="帽子/ハット/キャップ">帽子/ハット/キャップ</option></li>
								<li><option class="dropdown-item bg-white" value="手袋/グローブ">手袋/グローブ</option></li>
								<li><option class="dropdown-item bg-white" value="登山グッズ">登山グッズ</option></li>
							</select>
						</form>
					</ul>
				</li>
			</ul>
			<ul class="navbar-nav mb-2 mb-lg-0 ms-lg-4">
				@guest
				<li class="nav-item"><a class="nav-link" aria-current="page" href="{{route('user.create')}}">Register<br>新規登録</a></li>
				<li class="nav-item"><a class="nav-link" href="{{route('auth.index')}}">Login<br>ログイン</a></li>
				@endguest
				@auth
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">User Manu<br>ユーザーメニュー</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="#">ユーザーメニュー</a></li>
							<li><hr class="dropdown-divider" /></li>
							<li>
								<form class="d-flex" method="get" action="{{route('user.edit')}}" name="editform">
									@csrf
									<input type="hidden" name="user_update_flg" value="1">
									<input type="hidden" name="id" value="{{Auth::id()}}">
									<a class="dropdown-item" aria-current="page" href="javascript:editform.submit()">登録情報変更</a>		
								</form>
							</li>
							<li>
								<form class="d-flex" method="post" action="{{route('auth.index')}}" name="logoutform">
									@csrf
									<input type="hidden" name="logout_flg" value="1">
									<input type="hidden" name="id" value="1">
									<a class="dropdown-item" aria-current="page" href="javascript:logoutform.submit()">ログアウト</a>
								</form>
							</li>
						</ul>
					</li>
					@if(Auth::user()->user_authority == 1)
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin Manu<br>管理メニュー</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="#">管理メニュー</a></li>
							<li><hr class="dropdown-divider" /></li>
								<li><a class="dropdown-item" href="{{route('user.index')}}">ユーザー一覧</a></li>
								<li><a class="dropdown-item" href="{{route('user.create')}}">管理ユーザー追加</a></li>
								<li><a class="dropdown-item" href="{{route('item.index')}}">商品一覧</a></li>
								<li><a class="dropdown-item" href="{{route('item.create')}}">商品追加</a></li>
							</li>
						</ul>
					</li>
					@endif
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
				<form class="d-flex" action="{{route('item.cart')}}" method="get" name="cartform">
					@csrf
					<input type="hidden" name="cart_add" value="1">
					<a href="javascript:cartform.submit()" class="btn btn-outline-dark" type="submit">
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
					</a>
				</form>
			</div>
		</div>
	</div>
</nav>
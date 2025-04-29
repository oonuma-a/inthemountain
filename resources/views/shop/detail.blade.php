@extends('layouts.layout')
@section('css')
    <link href="{{asset('/css/homepage_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/homepage_scripts.js')}}"></script>
@endsection
@section('content')
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="header-img"></div>
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white article-word">
                <h1 class="display-4 fw-bolder">IN THE MOUNTAIN ONLINE SHOP</h1>
                <p class="lead fw-normal text-white-50 mb-0">to the top.</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <div class="py-5-detail">
        <div class="item-view-option">
            <!-- 詳細表示 -->
            <form action="{{route('shop.index')}}" method="get" name="detailform" class="detail-form">
                @foreach(request()->except('page', 'detail_select') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <select name="detail_select" class="detail-select" onchange="submit()">
                    <option value="1">一覧表示</option>
                    <option value="2" selected>詳細表示</option>
                </select>
            </form>

            <!-- 検索フォーム -->
            <div class="item-view-option-right">

                <!-- セール中の商品 -->
                <form action="{{route('shop.index')}}" method="get" name="saleform">
                    @foreach(request()->except('page', 'sale_search') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <input type="checkbox" name="sale_search" onchange="submit()"

                    @if(!empty($inputs['sale_search']))
                        value=""
                        {{ $inputs['sale_search'] ? 'checked' : '' }}
                    @else
                        value="1"
                    @endif
                    >
                </form>

                <!-- アイテムカテゴリ検索 -->
                <form action="{{route('shop.index')}}" method="get">
                    @foreach(request()->except('page', 'detail_select') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="category_search"  class="dropdown-item" onchange="submit()">
                        <li>
                            <option class="dropdown-item bg-white">カテゴリー</option>
                        </li>
                        @foreach($categories as $category)
                            <li>
                            <option class="dropdown-item bg-white" value="{{$category}}"
                                @if(!empty($inputs['category_search']))
                                    {{ $category == $inputs['category_search'] ? 'selected' : '' }}
                                @endif
                            >
                                {{$category}}
                            </option>
                            </li>
                        @endforeach
                    </select>
                </form>
                <!-- 商品検索 -->
                <form method="get" action="{{ route('shop.index') }}" name="searchform">
                    @foreach(request()->except('page', 'item_name_search') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div class="search-area">
                        <input type="text" name="item_name_search" class="search-item"
                            value="{{ request('item_name_search', '') }}" placeholder="商品名を検索する">
                        <a href="javascript:searchform.submit()" class="search-icon">
                            <img src="{{ asset('image/search-icon.png') }}" alt="">
                        </a>
                    </div>
                </form>

                <!-- 表示件数 -->
                <div class="view-option-right-bottom">
                    <form action="{{route('shop.index')}}" method="get" class="item-pagination-form">
                        @foreach(request()->except('page', 'paginateChangeValue') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        表示件数：<select name="paginateChangeValue"  onchange="submit()" class="item-select">
                            @foreach($pagedata['paginateArray'] as $paginate)
                                @if($pagedata['paginateChangeValue'] == $paginate)
                                    <option value="{{$paginate}}" selected>{{$paginate}}件</option>
                                @else
                                    <option value="{{$paginate}}">{{$paginate}}件</option>
                                @endif
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <!-- ページネーション -->
        <div class="pagination">
            {{ $itemdata->appends(request()->all())->links() }}
        </div>
            <!-- 商品一覧 -->
            @if(count($itemdata) == 0)
                <div class="detail-row">
                    <p>商品がありません。</p>
                </div>
            @else
                @foreach($itemdata as $data)
                    <div class="detail-row">
                        <div class="detail-row-child">
                            <!-- Sale badge-->
                            @if(isset($data->discount_price))
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            @endif
                            <!-- Product image-->
                            <div class="detail-left-column">
                                <a href="{{route('item.view', ['id' => $data->id, 'from' => 'shop'])}}">
                                    @if(is_null($data->image))
                                        <img class="detail-card-img-top" src="{{ Storage::url('public/image/blank_image.png')}}" alt="商品の画像">
                                    @else
                                        <img class="detail-card-img-top" src="{{ Storage::url($data->image)}}" alt="商品の画像">
                                    @endif
                                </a>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2 item-star">
                                    @if(isset($data->star))
                                        @for($i = 0; $i < $data->star; $i++)
                                            <div class="bi-star-fill"></div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            <div class="detail-right-column">
                                <div class="detail-right-top">
                                    <!-- Product name-->
                                    <a href="{{route('item.view', ['id' => $data->id])}}">
                                        <h5 class="fw-bolder detail-fw-bolder">{{$data->item_name}}</h5>
                                    </a>
                                    <p class="detail-category">{{$data->item_category}}</p>
                                    <p class="detail-text">{{$data->item_text}}</p>
                                    <!-- Product price-->
                                    <p>
                                    @if(isset($data->discount_price))
                                        <p><span class="detail-text-muted text-decoration-line-through">{{$data->price}}円</span>&nbsp;
                                        <span class="detail-price price-discount ">{{$data->discount_price}}円</span></p>
                                    @else
                                        <span class="detail-price detail-text-muted">{{$data->price}}円</span>
                                    @endif
                                    </p>
                                </div>
                                <!-- Product actions-->
                                <div class="detail-right-bottom">
                                    <a class="btn btn-outline-dark mt-auto detail-btn" href="javascript:itemCartForm_{{$loop->index}}.submit()">カートに追加</a>
                                    @auth
                                        @if(Auth::user()->user_authority == 1)
                                            <a class="btn btn-outline-dark item-btn" href="{{route('item.edit', ['id' => $itemdata->id, 'from' => 'shop'])])}}">
                                                商品を編集
                                            </a>

                                            <form action="{{route('item.destroy', ['id' => $data->id, 'from' => 'shop'])}}" method="post">
                                                @csrf
                                                <input type="submit" class="btn btn-outline-dark mt-auto detail-btn">商品を削除</a>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            <!-- Product actions-->
                            <form action="{{route('item.cart')}}" method="post" name="itemCartForm_{{$loop->index}}">
                                @csrf
                                <input type="hidden" name="cart_add_flg" value="1">
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <input type="hidden" name="item_number" value="1">
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        <!-- ページネーション -->
        <div class="pagination">
            @if(isset($item_name_search) or isset($paginateChangeValue))
                {{$itemdata->appends(request()->input())->links()}}
            @else
                {{$itemdata->links() }}
            @endif
        </div>
    </div>
@endsection

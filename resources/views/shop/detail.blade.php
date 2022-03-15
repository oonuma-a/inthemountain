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
                @csrf
                @if(isset($paginateChangeValue))
                    <input type="hidden" name="paginateChangeValue" value="{{$paginateChangeValue}}">
                @endif
                @if(isset($item_name_search))
                    <input type="hidden" name="item_name_search" class="search-item" value="{{$item_name_search}}">
                @endif
                @if(isset($sale_search))
                    <input type="hidden" name="sale_search" value="1">
                @endif
                @if(isset($category_search))
                    <input type="hidden" name="category_search" value="{{$category_search}}">
                @endif
                <select name="detail_select" class="detail-select" onchange="submit()">
                    <option value="1">一覧表示</option>
                    <option value="2" selected>詳細表示</option>
                </select>
            </form>               
            <div class="item-view-option-right">
                <!-- 商品検索 -->
                <form  method="get" action="{{route('shop.index')}}" name="searchform">
                    @csrf
                    @if(isset($paginateChangeValue))
                        <input type="hidden" name="paginateChangeValue" value="{{$paginateChangeValue}}">
                    @endif
                    @if(isset($sale_search))
                        <input type="hidden" name="sale_search" value="1">
                    @endif
                    @if(isset($category_search))
                        <input type="hidden" name="category_search" value="{{$category_search}}">
                    @endif
                    @if(isset($detail_select))
                        <input type="hidden" name="detail_select" value="{{$detail_select}}">
                    @endif
                    <input type="hidden" name="item_search_flg" value="1">
                    <div class="search-area">
                        @if(isset($item_name_search))
                            <input type="text" name="item_name_search" class="search-item" value="{{$item_name_search}}">
                        @else
                            <input type="text" name="item_name_search" class="search-item" placeholder="商品名を検索する">
                        @endif
                        <a href="javascript:searchform.submit()" class="search-icon">
                            <img src="{{asset('image/search-icon.png')}}" alt="">
                        </a>
                    </div>
                </form>
                <!-- 表示件数 -->
                <div class="view-option-right-bottom">
                    <form action="{{route('shop.index')}}" method="get" class="item-pagination-form">
                        @csrf
                        @if(isset($item_name_search))
                            <input type="hidden" name="item_name_search" class="search-item" value="{{$item_name_search}}">
                        @endif
                        @if(isset($sale_search))
                            <input type="hidden" name="sale_search" value="1">
                        @endif
                        @if(isset($category_search))
                            <input type="hidden" name="category_search" value="{{$category_search}}">
                        @endif
                        @if(isset($detail_select))
                            <input type="hidden" name="detail_select" value="{{$detail_select}}">
                        @endif
                        表示件数：<select name="paginateChangeValue"  onchange="submit()" class="item-select">
                        @foreach($paginateArray as $paginate)
                            @if($paginateChangeValue == $paginate)
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
            @if(isset($item_name_search) or isset($paginateChangeValue))
                {{$itemdata->appends(request()->input())->links()}}
            @else
                {{$itemdata->links() }}
            @endif
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
                                <form action="{{route('item.view')}}" method="get" name="itemImgForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="item_check_flg" value="1">
                                    @if(is_null($data->image))
                                        <a href="javascript:itemImgForm_{{$loop->index}}.submit()">
                                            <img class="detail-card-img-top" src="{{ Storage::url('public/image/blank_image.png')}}" alt="商品の画像">
                                        </a>
                                    @else
                                        <a href="javascript:itemImgForm_{{$loop->index}}.submit()">
                                            <img class="detail-card-img-top" src="{{ Storage::url($data->image)}}" alt="商品の画像">
                                        </a>
                                    @endif
                                </form>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2 item-star">
                                    @if(isset($data->star))
                                        @for($i = 0; $i < $data->star; $i++)
                                            <div class="bi-star-fill"></div>
                                        @endfor
                                    @else
                                    @endif
                                </div>
                            </div>
                            <div class="detail-right-column">
                                <div class="detail-right-top">
                                    <!-- Product name-->
                                    <form action="{{route('item.view')}}" method="get" name="itemnameForm_{{$loop->index}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <a href="javascript:itemnameForm_{{$loop->index}}.submit()">
                                            <h5 class="fw-bolder detail-fw-bolder">{{$data->item_name}}</h5>
                                        </a>
                                    </form>
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
                                            <a class="btn btn-outline-dark mt-auto detail-btn" href="javascript:itemUpdateForm_{{$loop->index}}.submit()">商品を編集</a>
                                            <a class="btn btn-outline-dark mt-auto detail-btn" href="javascript:itemDeleteForm_{{$loop->index}}.submit()">商品を削除</a>
                                        @endif
                                    @endauth
                                </div>
                            </div>                               
                            <!-- Product actions-->
                            <form action="{{route('item.index')}}" method="post" name="itemDeleteForm_{{$loop->index}}">
                                @csrf
                                <input type="hidden" name="item_delete_flg" value="1">
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <input type="hidden" name="detail_flg" value="1">
                            </form>
                            <form action="{{route('item.edit')}}" method="get" name="itemUpdateForm_{{$loop->index}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$data->id}}">
                            </form>
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

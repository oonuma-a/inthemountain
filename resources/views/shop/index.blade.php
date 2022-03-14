@extends('layouts.layout')
@section('css')
    <link href="{{asset('/css/homepage_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/homepage_scripts.js')}}"></script>
@endsection
@section('content')
<!-- Header-->
    <header class="bg-dark py-5">
        <!-- <div class="header-img"></div> -->
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white article-word">
                <h1 class="display-4 fw-bolder">IN THE MOUNTAIN ONLINE SHOP</h1>
                <p class="lead fw-normal text-white-50 mb-0">to the top.</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <div class="py-5">
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
                @if(isset($detail_select))
                    <input type="hidden" name="detail_select" value="{{$detail_select}}">
                @endif
                <select name="detail_select" class="detail-select" onchange="submit()">
                    <option value="1" selected>一覧表示</option>
                    <option value="2">詳細表示</option>
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
        
        <div class="container px-4 px-lg-5 mt-4">
                <!-- 商品一覧 -->
                @if(count($itemdata) == 0)
                    <div class="col mb-5">
                        <tr>
                            <p>商品がありません。</p>
                        </tr>
                    </div>
                @else
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach($itemdata as $data)
                        <div class="col mb-5">
                            <div class="card h-100">
                                <form action="{{route('item.view')}}" method="get" name="itemForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <!-- Sale badge-->
                                    @if(isset($data->discount_price))
                                        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                    @endif
                                    <!-- Product image-->
                                    <div class="item-img">
                                        @if(is_null($data->image))
                                            <a href="javascript:itemForm_{{$loop->index}}.submit()">
                                                <img class="card-img-top" src="{{ Storage::url('public/image/blank_image.png')}}" alt="商品の画像">
                                            </a>
                                        @else
                                            <a href="javascript:itemForm_{{$loop->index}}.submit()">
                                                <img class="card-img-top" src="{{ Storage::url($data->image)}}" alt="商品の画像">
                                            </a>
                                        @endif
                                    </div>
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <a href="javascript:itemForm_{{$loop->index}}.submit()">
                                                <h5 class="fw-bolder">{{$data->item_name}}</h5>
                                            </a>
                                            <!-- Product reviews-->
                                            <div class="d-flex justify-content-center small text-warning mb-2 item-star">
                                                @if(isset($data->star))
                                                    @for($i = 0; $i < $data->star; $i++)
                                                        <div class="bi-star-fill"></div>
                                                    @endfor
                                                @else
                                                @endif
                                            </div>
                                            <!-- Product price-->
                                            @if(isset($data->discount_price))
                                                <span class="text-muted text-decoration-line-through">{{$data->price}}円</span><br>
                                                <span class="price-discount">{{$data->discount_price}}円</span>
                                            @else
                                                <span class="text-muted">{{$data->price}}円</span>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                                <!-- Product actions-->
                                <form action="{{route('item.cart')}}" method="post" name="itemCartForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="cart_add_flg" value="1">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="item_number" value="1">
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="javascript:itemCartForm_{{$loop->index}}.submit()">カートに追加</a></div>
                                    </div> 
                                </form>
                                <!-- Product actions Update & delete-->
                                @auth
                                    @if(Auth::user()->user_authority == 1)
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <form action="{{route('item.edit')}}" method="get" name="itemUpdateForm_{{$loop->index}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$data->id}}">
                                                <div class="text-center">
                                                    <a class="btn btn-outline-dark mt-auto" href="javascript:itemUpdateForm_{{$loop->index}}.submit()">商品を編集</a>
                                                </div>
                                            </form>
                                        </div> 
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <form action="{{route('item.index')}}" method="post" name="itemDeleteForm_{{$loop->index}}">
                                                @csrf
                                                <input type="hidden" name="item_delete_flg" value="1">
                                                <input type="hidden" name="id" value="{{$data->id}}">
                                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="javascript:itemDeleteForm_{{$loop->index}}.submit()">商品を削除</a></div>
                                            </form>
                                        </div> 
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        
        <!-- ページネーション -->
        <div class="d-flex justify-content-center small text-warning mb-2">
            @if(isset($item_name_search) or isset($paginateChangeValue))
                {{$itemdata->appends(request()->input())->links()}}
            @else
                {{$itemdata->links() }}
            @endif
        </div>
    </div>
@endsection

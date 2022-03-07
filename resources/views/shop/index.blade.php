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
    <section class="py-5">
        <div class="item-view-option">
            <!-- 詳細表示 -->
            <form action="{{route('shop.detail')}}" method="get" name="detailform" class="detail-form">
                @csrf
                @if(isset($paginateChangeValue))
                    <input type="hidden" name="paginateChangeValue" value="{{$paginateChangeValue}}">
                @endif
                @if(isset($item_search_flg))
                    <input type="hidden" name="item_search_flg" value="1">
                    <input type="hidden" name="searchItemName" value="{{$searchItemName}}">
                @endif
                <select name="detail_select" id="detail_select" onchange="submit()">
                    <option value="1" selected>一覧表示</option>
                    <option value="2">詳細表示</option>
                </select>
            </form>
            <!-- 商品検索 -->
            <form class="d-flex" method="get" action="{{route('shop.index')}}" name="searchform">
                @csrf
                @if(isset($paginateChangeValue))
                    <input type="hidden" name="paginateChangeValue" value="{{$paginateChangeValue}}">
                @endif
                <input type="hidden" name="item_search_flg" value="1">
                <div class="search-icon">
                    <img src="{{asset('image/search-icon.png')}}" alt="">
                    @if(isset($item_search_flg))
                        <input type="hidden" name="item_search_flg" value="1">
                        <input type="text" name="searchItemName" id="search-item" value="{{$searchItemName}}">
                    @else
                        <input type="text" name="searchItemName" id="search-item" placeholder="商品を検索する">
                    @endif
                    <a href="javascript:searchform.submit()">検索</a>
                </div>
            </form>
            <!-- ページネーション -->
            <div class="pagination">
                @if(isset($item_search_flg) or isset($paginateChangeValue))
                    {{$itemdata->appends(request()->input())->links()}}
                @else
                    {{$itemdata->links() }}
                @endif
            </div>
            <!-- 表示件数 -->
            <div class="item-view-option-right">
                <form action="{{route('shop.index')}}" method="get" class="item-pagination-form">
                    @csrf
                    @if(isset($item_search_flg))
                        <input type="hidden" name="item_search_flg" value="1">
                        <input type="hidden" name="searchItemName" value="{{$searchItemName}}">
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
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- 商品一覧 -->
                @if(count($itemdata) == 0)
                    <div class="col mb-5">
                        <tr>
                            <p>商品がありません。</p>
                        </tr>
                    </div>
                @else
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
                                                <span class="text-decoration-line-through">¥{{$data->price}}</span>
                                                <span class="price-discount">¥{{$data->discount_price}}</span>
                                            @else
                                                <span class="">¥{{$data->price}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                                <!-- Product actions-->
                                
                                <form action="{{route('item.cart')}}" method="post" name="itemCartForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="item_cart_flg" value="1">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="item_number" value="1">
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="javascript:itemCartForm_{{$loop->index}}.submit()">カートに追加</a></div>
                                    </div> 
                                </form>
                                <!-- Product actions Update & delete-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <form action="{{route('item.index')}}" method="post" name="itemDeleteForm_{{$loop->index}}">
                                        @csrf
                                        <input type="hidden" name="item_delete_flg" value="1">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="javascript:itemDeleteForm_{{$loop->index}}.submit()">商品を削除</a></div>
                                    </form>
                                </div> 
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <form action="{{route('item.edit')}}" method="get" name="itemUpdateForm_{{$loop->index}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <div class="text-center">
                                            <a class="btn btn-outline-dark mt-auto" href="javascript:itemUpdateForm_{{$loop->index}}.submit()">商品を編集</a>
                                        </div>
                                    </form>
                                </div> 
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        
        <!-- ページネーション -->
        <div class="d-flex justify-content-center small text-warning mb-2">
            @if(isset($item_search_flg) or isset($paginateChangeValue))
                {{$itemdata->appends(request()->input())->links()}}
            @else
                {{$itemdata->links() }}
            @endif
        </div>
    </section>
@endsection

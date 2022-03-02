@extends('layouts.layout')
@section('css')
    <link href="{{asset('/css/homepage_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/homepage_scripts.js')}}"></script>
@endsection
@section('content')
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">IN THE MOUNTAIN ONLINE SHOP</h1>
                <p class="lead fw-normal text-white-50 mb-0">to the top.</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="">
    <div class="item-view-option">
            <!-- 詳細表示 -->
            <form action="{{route('shop.index')}}" method="get" name="detailform" class="detail-form">
                @csrf
                @if(isset($paginateChangeValue))
                    <input type="hidden" name="paginateChangeValue" value="{{$paginateChangeValue}}">
                @endif
                @if(isset($item_search_flg))
                    <input type="hidden" name="item_search_flg" value="1">
                    <input type="hidden" name="searchItemName" value="{{$searchItemName}}">
                @endif
                <select name="detail_select" id="detail_select" onchange="submit()">
                    <option value="1">一覧表示</option>
                    <option value="2" selected>詳細表示</option>
                </select>
            </form>
            <!-- 商品検索 -->
            <form class="d-flex" method="get" action="{{route('shop.detail')}}" name="searchform">
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
                <form action="{{route('shop.detail')}}" method="get" class="item-pagination-form">
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


            <!-- 商品一覧 -->
            @if(count($itemdata) == 0)
                <tr>
                    <p>商品がありません。</p>
                </tr>
            @else
                @foreach($itemdata as $data)
                    <div class="detail-row">
                        <div class="detail-row-child">
                                <!-- Sale badge-->
                                @if(isset($data->discount_price))
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                @endif
                            <!-- <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div> -->

                            <form action="{{route('item.index')}}" method="get" name="itemImdForm_{{$loop->index}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <input type="hidden" name="item_check_flg" value="1">
                                <!-- Product image-->
                                <div class="detail-left-column">
                                    @if(is_null($data->image))
                                        <a href="javascript:itemImdForm_{{$loop->index}}.submit()">
                                            <img class="detail-card-img-top" src="{{ Storage::url('public/image/blank_image.png')}}" alt="商品の画像">
                                        </a>
                                    @else
                                        <a href="javascript:itemImdForm_{{$loop->index}}.submit()">
                                            <img class="detail-card-img-top" src="{{ Storage::url($data->image)}}" alt="商品の画像">
                                        </a>
                                    @endif

                                    
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
                            </form>
                            <div class="detail-right-column">
                                <div class="detail-right-top">
                                    <!-- Product name-->
                                    <form action="{{route('item.index')}}" method="get" name="itemnameForm_{{$loop->index}}">
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
                                            <span class="detail-text-muted text-decoration-line-through">¥{{$data->discount_price}}</span>
                                            <span class="detail-price price-discount">¥{{$data->price}}</span>
                                        @else
                                            <span class="detail-price">¥{{$data->price}}</span>
                                        @endif
                                    </p>
                                </div>
                                <!-- Product Update & delete-->
                                <div class="detail-right-bottom">
                                    <a class="btn btn-outline-dark mt-auto detail-btn" href="#">カートに追加</a>
                                    <a class="btn btn-outline-dark mt-auto detail-btn" href="javascript:itemUpdateForm_{{$loop->index}}.submit()">商品を編集</a>
                                    <a class="btn btn-outline-dark mt-auto detail-btn" href="javascript:itemDeleteForm_{{$loop->index}}.submit()">商品を削除</a>
                                </div>
                            </div>                               
                            <!-- Product actions Update & delete-->
                            <div class="">
                                <form action="{{route('item.index')}}" method="post" name="itemDeleteForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="item_delete_flg" value="1">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="detail_flg" value="1">
                                </form>
                            </div> 
                            <div class="">
                                <form action="{{route('item.edit')}}" method="get" name="itemUpdateForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                </form>
                            </div> 
                        </div>
                    </div>
                @endforeach
            @endif
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

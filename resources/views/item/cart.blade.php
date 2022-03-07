@extends('layouts.layout')
@section('css')
    <link href="{{asset('/css/homepage_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/homepage_scripts.js')}}"></script>
@endsection
@section('content')
    <section class="">
        <!-- 商品一覧 -->
        @if(is_null($itemData))
            <tr>
                <p>商品がありません。</p>
            </tr>
        @else
            @foreach($itemData as $data)
                <div class="detail-row">
                    <div class="detail-row-child">
                        <!-- Sale badge-->
                        @if(isset($data->discount_price))
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                        @endif
                        <div class="detail-left-column">
                            <form action="{{route('item.view')}}" method="get" name="itemImgForm_{{$loop->index}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <input type="hidden" name="item_check_flg" value="1">
                                <!-- Product image-->
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
                                
                                <!-- Product price-->
                                
                                @if(isset($data->discount_price))
                                    <p><span class="detail-text-muted text-decoration-line-through">¥{{$data->price}}</span>
                                    <span class="detail-price price-discount ">¥{{$data->discount_price}}</span></p>
                                @else
                                    <span class="detail-price">¥{{$data->price}}</span>
                                @endif
                                <p>数量：{{ $itemQuantity['id_'.$data->id]}}個</p>
                                <p>
                                    @if(isset($data->discount_price))
                                       合計：<span class="detail-text-muted">¥{{$itemQuantity['id_'.$data->id] * $data->discount_price}}</span>
                                    @else
                                       合計：<span class="detail-price">¥{{$itemQuantity['id_'.$data->id] * $data->price}}</span>
                                    @endif
                                </p>
                            </div>
                            <!-- Product Update & delete-->
                            <div class="detail-right-bottom">
                                <a class="btn btn-outline-dark mt-auto detail-btn" href="#">カートに追加</a>
                                <a class="btn btn-outline-dark mt-auto detail-btn" href="javascript:itemDeleteForm_{{$loop->index}}.submit()">カートから削除</a>
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
                <span class="">{{$data->cartItemNumber}}</span>
            @endforeach
        @endif
        <form action="{{route('item.cart')}}" method="post" name="cartdrop">
            @csrf
            <input type="hidden" name="cart_drop_flg" value="1">
            <a class="btn btn-outline-dark mt-auto detail-btn" href="javascript:cartdrop.submit()">カートを空にする</a>
        </form>
    </section>
@endsection

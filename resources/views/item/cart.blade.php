@extends('layouts.layout')
@section('css')
    <link href="{{asset('/css/homepage_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/homepage_scripts.js')}}"></script>
@endsection
@section('content')
        <!-- 商品一覧 -->
        @if(count($itemdata) == 0)
            <div class="detail-row">
                <tr>
                    <p>商品がありません。</p>
                </tr>
            </div>
        @else
            <div class="detail-row">
                <div class="cart-total-price">
                    <p class="detail-price detail-text-muted">合計：
                    <?php
                        $price = 0;
                        foreach($itemdata as $data){
                            if(isset($data->discount_price)){
                                $price = $price + $itemQuantity['id_'.$data->id] * $data->discount_price;
                            }else{
                                $price = $price + $itemQuantity['id_'.$data->id] * $data->price;
                            }
                        }
                        echo $price;
                    ?>円</p>

                    <!-- <form action="{{route('cart.index')}}" method="post" name="cartbuy"> -->
                        <!-- @csrf -->
                        <input type="hidden" name="cart_buy_flg" value="1">
                        <button class="btn btn-outline-orange mt-auto" onclick="alert('画面はここまでです');">購入画面へ進む</a>
                    <!-- </form> -->
                </div>
            </div>
            @foreach($itemdata as $data)
                <div class="detail-row">
                    <div class="detail-row-child">
                        <!-- Sale badge-->
                        @if(isset($data->discount_price))
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                        @endif
                        <div class="detail-left-column">
                                <!-- Product image-->
                                <a href="{{route('item.view', ['id' => $data->id, 'from' => 'cart'])}}">
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
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="detail-right-column">
                            <div class="detail-right-top">
                                <!-- Product name-->
                                <a href="{{route('item.view', ['id' => $data->id, 'from' => 'cart'])}}">
                                    <h5 class="fw-bolder detail-fw-bolder">{{$data->item_name}}</h5>
                                </a>
                                <p class="detail-category">{{$data->item_category}}</p>

                                <!-- Product price-->

                                @if(isset($data->discount_price))
                                    <p><span class="detail-text-muted text-decoration-line-through">{{$data->price}}円</span>
                                    <span class="detail-price price-discount ">{{$data->discount_price}}円</span></p>
                                @else
                                    <span class="detail-price detail-text-muted">{{$data->price}}円</span>
                                @endif
                                <form action="{{ route('cart.update') }}" method="post" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <label style="display: inline;">
                                        数量：
                                        <select name="item_number" onchange="this.form.submit()" style="display: inline;">
                                            @for ($i = 1; $i <= $data->item_number; $i++)
                                                <option value="{{ $i }}" @if ($itemQuantity['id_'.$data->id] == $i) selected @endif>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        個
                                    </label>
                                </form>
                                <p class="detail-right-bottom">
                                    @if(isset($data->discount_price))
                                       合計：<span class="detail-text-muted text-decoration-line-through">{{$itemQuantity['id_'.$data->id] * $data->price}}円</span>&nbsp;
                                       <span class="detail-price price-discount" style="display: inline;">{{$itemQuantity['id_'.$data->id] * $data->discount_price}}円</span>
                                    @else
                                       合計：<span class="detail-price detail-text-muted" style="display: inline;">{{$itemQuantity['id_'.$data->id] * $data->price}}円</span>
                                    @endif
                                </p>
                            </div>
                            <!-- Product remove -->
                            <div class="detail-right-bottom">
                                <form action="{{route('cart.remove')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="item_number" value="{{$itemQuantity['id_'.$data->id]}}">
                                    <button type="submit" class="btn btn-outline-dark mt-auto detail-btn">
                                        カートから削除
                                    </button>
                                </form>
                            </div>                               
                        </div> 
                    </div>
                </div>
                <span class="">{{$data->cartItemNumber}}</span>
            @endforeach
            <div class="detail-row">
                <div class="detail-row">
                    <div class="btn-bottom">
                        <form action="{{route('cart.clear')}}" method="post">
                            @csrf
                            <button type="subimt" class="common-btn">
                                カートを空にする
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
@endsection

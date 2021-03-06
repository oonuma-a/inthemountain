@extends('layouts.layout')
@section('css')
    <link href="{{asset('/css/item_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/item_scripts.js')}}"></script>
@endsection
@section('content')
 <!-- Product section-->
<div class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                @if(is_null($selectItem->image))
                        <img class="card-img-top mb-5 mb-md-0" src="{{ Storage::url('public/image/blank_image.png')}}" alt="商品の画像">
                @else
                        <img class="card-img-top mb-5 mb-md-0" src="{{ Storage::url($selectItem->image)}}" alt="商品の画像">
                @endif
            </div>
            <div class="col-md-6">
                <div class="small mb-1">{{$selectItem->item_category}}</div>
                <h1 class="display-5 fw-bolder">{{$selectItem->item_name}}</h1>
                <div class="fs-5 mb-5">
                    @if(isset($selectItem->discount_price))
                        <span class="text-decoration-line-through">¥{{$selectItem->price}}</span>
                        <span class="price-discount">¥{{$selectItem->discount_price}}</span>
                    @else
                        <span>¥{{$selectItem->price}}</span>
                    @endif
                </div>
                <p class="lead">{{$selectItem->item_text}}</p>
                <div class="item-view-cart">
                    <form action="{{route('item.cart')}}" method="post" name="itemCartForm">
                        @csrf
                        <input type="hidden" name="cart_add_flg" value="1">
                        <input type="hidden" name="id" value="{{$selectItem->id}}">
                        <select class="form-control text-center me-3" id="item_number" name="item_number" style="max-width: 3rem" >
                            @for($i=1; $i <= 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </form>
                    <a class="btn btn-outline-dark item-btn" href="javascript:itemCartForm.submit()">カートに追加</a>
                    @auth
                        @if(Auth::user()->user_authority == 1)
                            <form action="{{route('item.edit')}}" method="get" name="itemUpdateForm">
                                @csrf
                                <input type="hidden" name="id" value="{{$selectItem->id}}">
                                <a class="btn btn-outline-dark item-btn" href="javascript:itemUpdateForm.submit()">商品を編集</a>
                            </form>
                            <form action="{{route('item.index')}}" method="post" name="itemDeleteForm">
                                @csrf
                                <input type="hidden" name="item_delete_flg" value="1">
                                <input type="hidden" name="id" value="{{$selectItem->id}}">
                                <a class="btn btn-outline-dark item-btn" href="javascript:itemDeleteForm.submit()">商品を削除</a>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Related items section-->
    @if(1 == 0)
        <div class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <!-- foreach -->
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Sale badge-->
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                <!-- Product image-->
                                <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">Special Item</h5>
                                        <!-- Product reviews-->
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                        </div>
                                        <!-- Product price-->
                                        <span class="text-muted text-decoration-line-through">$20.00</span>
                                        $18.00
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                                </div>
                            </div>
                        </div>
                    <!-- endforeach -->
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

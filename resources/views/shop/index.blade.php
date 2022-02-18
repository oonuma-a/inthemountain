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
                <p class="lead fw-normal text-white-50 mb-0">in your heart.</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <!-- ページネーション -->
        @if(isset($searchItem))
            {{$searchItem->appends(request()->input())->links()}}
        @else
            {{$itemdata->links() }}
        @endif
        <form action="{{route('shop.index')}}" method="get">
            @csrf
            表示家数：<select name="item_pagination"  onchange="submit()">
                @if(isset($paginateChangeValue))
                    <option value="{{$paginateChangeValue}}">{{$paginateChangeValue}}</option>件
                    @foreach($paginateArray as $paginate)
                        @if($paginate == $paginateChangeValue)
                            @continue
                        @else
                            <option value="{{$paginate}}">{{$paginate}}</option>件
                        @endif
                    @endforeach
                @else
                    @foreach($paginateArray as $paginate)
                        <option value="{{$paginate}}">{{$paginate}}</option>件
                    @endforeach
                @endif
            </select>
        </form>

        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            @if(is_null($itemdata))
                <tr>
                    <p>該当商品がありません。</p>
                </tr>
            @else
                @foreach($itemdata as $data)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <form action="{{route('item.index')}}" method="get" name="itemForm_{{$loop->index}}">
                                @csrf
                                <input type="hidden" name="item_check_flg" value="1">
                                <!-- Sale badge-->
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <!-- Product image-->
                                <a href="javascript:itemForm_{{$loop->index}}.submit()">
                                <img class="card-img-top" src="{{ Storage::url($data->image)}}">
                                </a>
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <a href="javascript:itemForm_{{$loop->index}}.submit()">
                                            <h5 class="fw-bolder">{{$data->item_name}}</h5>
                                        <a>
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
                                        ¥{{$data->price}}
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                                </div> 
                            </form>
                            <!-- Product actions Update & delete-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <form action="{{route('shop.index')}}" method="post" name="itemDeleteForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="item_delete_flg" value="1">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="javascript:itemDeleteForm_{{$loop->index}}.submit()">商品を削除</a></div>
                                </form>
                            </div> 
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <form action="{{route('item.index')}}" method="get" name="itemUpdateForm_{{$loop->index}}">
                                    @csrf
                                    <input type="hidden" name="item_update_flg" value="1">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="javascript:itemUpdateForm_{{$loop->index}}.submit()">商品を編集</a></div>
                                </form>
                            </div> 
                        </div>
                    </div>
                @endforeach
            @endif
            </div>
        </div>
    </section>
@endsection

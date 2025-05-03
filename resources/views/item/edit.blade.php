@extends('layouts.layout')
@section('css')
    <link href="{{asset('/css/item_styles.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/item_scripts.js')}}"></script>
@endsection
@section('content')
 <!-- Product section-->
    <div class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <ul class="error-message-list">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
            <form action="{{route('item.update', ['id' => $itemdata->id, 'from' => request()->query('from') ])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        @if(is_null($itemdata->image))
                            <p>商品画像がありません。</p>
                        @else
                            <p>現在の商品画像</p>
                            <img class="card-img-top mb-5 mb-md-0" src="{{ url('storage/image/' . basename($itemdata->image)) }}" alt="商品の画像" />
                        @endif
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="col-md-6">
                        <p>商品名：<input class="small mb-1" type="text" name="item_name" value="{{$itemdata->item_name}}"><span class="required-form">必須</span></p>
                        <p>商品カテゴリー：<select name="item_category">
                            @foreach($categories as $category)
                                <option value="{{$category}}"
                                    @if(!empty($itemdata->item_category))
                                        {{ $category == $itemdata->item_category ? 'selected' : '' }}
                                    @endif
                                >
                                    {{$category}}
                                </option>
                            @endforeach
                        </select><span class="required-form">必須</span></p>
                        <p>商品価格：<input class="small mb-1" type="text" name="price" value="{{$itemdata->price}}">円<span class="required-form">必須</span></p>
                        <p>値引き後価格：<input class="small mb-1" type="text" name="discount_price" value="{{$itemdata->discount_price}}">円</p>
                        <p>おすすめ度：<select name="star">
                                @for($i=1; $i <= 5; $i++)
                                    @if($i == $itemdata->star)
                                        <option value="{{$i}}" selected>
                                            @for($j=0; $j < $i; $j++)
                                                ★ 
                                            @endfor
                                        </option>
                                    @else
                                        <option value="{{$i}}">
                                            @for($j=0; $j < $i; $j++)
                                                ★
                                            @endfor
                                        </option>
                                    @endif
                                @endfor
                            </option>
                            <!-- <option value="1">★</option> -->
                            </select>
                        <p>商品の説明文：<span class="required-form">必須</span></p>
                        <p class="lead"><textarea name="item_text" id="item_text" cols="30" rows="10">{{$itemdata->item_text}}</textarea>
                        <p>数量：<input class="small mb-1" type="text" name="item_number" value="{{$itemdata->item_number}}">個<span class="required-form">必須</span></p>
                    </div>
                </div>
                <div class="d-flex">
                    <input type="submit" class="btn btn-outline-dark flex-shrink-0" value="商品を更新">
                </div>
            </form>
        </div>
    </div>
@endsection

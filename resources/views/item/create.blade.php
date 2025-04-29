@extends('layouts.layout')
@section('css')
        <link href="{{asset('/css/item_styles.css')}}" rel="stylesheet" />
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
            <div class="item-create-row">
                <form action="{{route('item.store')}}" method="post" name="itemForm" enctype="multipart/form-data">
                    @csrf
                    <div class="item-label ">
                        <p>商品名</p><div class="required-form">必須</div>
                    </div>
                    <input type="text" class="item-create-input" name="item_name">
                    
                    <div class="item-label ">
                        <p>商品カテゴリー</p><div class="required-form">必須</div>
                    </div>
                    <select name="item_category" class="item-create-input">
                        @foreach($categories as $category)
                            <option value="{{$category}}">{{$category}}</option>
                        @endforeach
                    </select>
                    <div class="item-label ">
                        <p>商品の説明文</p><div class="required-form">必須</div>
                    </div>
                    <textarea name="item_text" class="item-create-text"></textarea>
                    <div class="item-label ">
                        <p>商品画像</p>
                    </div>
                    <input type="file" class="item-create-input" name="image" id="image">                    
                    <div class="item-label ">
                        <p>商品価格</p><div  class="required-form">必須</div>
                    </div>
                    <input type="text" class="item-create-input" name="price">
                    <div class="item-label ">
                        <p>値引き後価格</p>
                    </div>
                    <input type="text" class="item-create-input" name="discount_price">
                    <div class="item-label ">
                        <p>おすすめ度</p>
                    </div>
                        <select name="star" class="item-create-input">
                            @for($i=1; $i <= 5; $i++)
                                <option value="{{$i}}">
                                    @for($j=0; $j < $i; $j++)
                                        ★
                                    @endfor
                                </option>
                            @endfor
                        </option>
                        </select>
                    <div class="item-label">
                        <p>数量</p><div  class="required-form">必須</div>
                    </div>
                    <input type="text" name="item_number" class="item-create-input">
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent item-create-btn">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="javascript:itemForm.submit()">商品登録</a></div>
                    </div>
                </form>    
            </div>
        </div>
    </div>
@endsection

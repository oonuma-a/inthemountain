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
                <form action="{{route('item.create')}}" method="post" name="itemForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_insert_flg" value="1">
                    <input type="hidden" name="user_id" value="1">
                    <div class="item-label ">
                        <p>商品名</p><div class="required-form">必須</div>
                    </div>
                    <input type="text" class="item-create-input" name="item_name">
                    
                    <div class="item-label ">
                        <p>商品カテゴリー</p><div class="required-form">必須</div>
                    </div>
                    <select name="item_category" class="item-create-input">
                        <option value="アウター">アウター</option>
                        <option value="インナー">インナー</option>
                        <option value="レインウェア">レインウェア</option>
                        <option value="パンツ">パンツ</option>
                        <option value="ハイキングシューズ">ハイキングシューズ</option>
                        <option value="トレッキングシューズ">トレッキングシューズ</option>
                        <option value="ブーツ">ブーツ</option>
                        <option value="スニーカー">スニーカー</option>
                        <option value="バッグ/リュック">バッグ/リュック</option>
                        <option value="帽子/ハット/キャップ">帽子/ハット/キャップ</option>
                        <option value="手袋/グローブ">手袋/グローブ</option>
                        <option value="登山グッズ">登山グッズ</option>
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

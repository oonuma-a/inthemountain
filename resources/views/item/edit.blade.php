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
            <form action="{{route('item.edit')}}" method="post" name="editform_{{$updateItem->id}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$updateItem->id}}">
                @if(isset($item_index_edit))
                    <input type="hidden" name="item_index_edit" value="1">
                @endif
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        @if(is_null($updateItem->image))
                            <p>商品画像がありません。</p>
                        @else
                            <p>現在の商品画像</p>
                            <img class="card-img-top mb-5 mb-md-0" src="{{ Storage::url($updateItem->image)}}" alt="商品の画像" />
                        @endif
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="col-md-6">
                        <p>商品名：<input class="small mb-1" type="text" name="item_name" value="{{$updateItem->item_name}}"><span class="required-form">必須</span></p>
                        <p>商品カテゴリー：<select name="item_category">
                            <option value="{{$updateItem->item_category}}">{{$updateItem->item_category}}</option>
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
                        </select><span class="required-form">必須</span></p>
                        <p>商品価格：<input class="small mb-1" type="text" name="price" value="{{$updateItem->price}}">円<span class="required-form">必須</span></p>
                        <p>値引き後価格：<input class="small mb-1" type="text" name="discount_price" value="{{$updateItem->discount_price}}">円</p>
                        <p>おすすめ度：<select name="star">
                                @for($i=1; $i <= 5; $i++)
                                    @if($i == $updateItem->star)
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
                        <p class="lead"><textarea name="item_text" id="item_text" cols="30" rows="10">{{$updateItem->item_text}}</textarea>
                        <p>数量：<input class="small mb-1" type="text" name="item_number" value="{{$updateItem->item_number}}">個<span class="required-form">必須</span></p>
                    </div>
                </div>
                <div class="d-flex">
                    <a class="btn btn-outline-dark flex-shrink-0" href="javascript:editform_{{$updateItem->id}}.submit()">
                        商品を更新
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.layout')
@section('css')
        <link href="{{asset('/css/item_styles.css')}}" rel="stylesheet" />
@endsection
@section('content')
 <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                    <form action="{{route('shop.index')}}" method="post" name="itemForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="item_insert_flg" value="1">
                        <input type="hidden" name="user_id" value="1">
                        item_name<br>
                        <input type="text" name="item_name" value="1"><br>
                        item_category<br>
                        <select name="item_category">
                            <option value="アウター">アウター</option>
                            <option value="レインウェア">レインウェア</option>
                            <option value="インナー">インナー</option>
                            <option value="スウェット">スウェット</option>
                            <option value="パンツ">パンツ</option>
                            <option value="アンダーウェア">アンダーウェア</option>
                            <option value="ハイキングシューズ">ハイキングシューズ</option>
                            <option value="トレッキングシューズ">トレッキングシューズ</option>
                            <option value="アルパインブーツ">アルパインブーツ</option>
                            <option value="スニーカー">スニーカー</option>
                            <option value="バッグ/リュック">バッグ/リュック</option>
                            <option value="帽子/ハット/キャップ">帽子/ハット/キャップ</option>
                            <option value="手袋/グローブ">手袋/グローブ</option>
                            <option value="登山グッズ">登山グッズ</option>
                        </select><br>
                        item_text<br>
                        <input type="text" name="item_text" value="1"><br>
                        image<br>
                        <input type="file" name="image" id="image"><br>
                        price<br>
                        <input type="text" name="price" value="1"><br>
                        discount_price<br>
                        <input type="text" name="discount_price" value="1"><br>
                        数量
                        <input type="text" name="item_number" value="100"><br>
                        <a href="javascript:itemForm.submit()">商品登録</a>
                    </form>    
               
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

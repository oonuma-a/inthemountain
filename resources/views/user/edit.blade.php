@extends('layouts.layout')
@section('css')   
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <!-- All the files that are required -->
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>

    <link href="{{asset('css/login_style.css')}}" rel="stylesheet" />
    <script src="{{asset('js/login_scripts.js')}}"></script>
@endsection
@section('content')
    <div class="container">
        <!-- Where all the magic happens -->
        <!-- REGISTRATION FORM -->
        <div class="text-center" style="padding:30px 0">
            <div class="logo">ユーザー情報変更</div>
        </div>
        <!-- Main Form -->
        <div class="login-form-1">
        <ul class="error-message-list">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
            <form id="register-form" class="text-left" name="updateform" method="post" action="{{route('user.edit')}}">
                @csrf
                <input type="hidden" name="user_update_flg" value="1">
                <input type="hidden" name="id" value="{{$userUpdate->id}}">
                <div class="login-form-main-message"></div>
                <div class="main-login-form">
                    <div class="login-group">
                        <div class="user-form">
                            <p class="sr-only">ユーザーID</p><span class="required-form">必須</span>
                            <input type="text" class="form-control" id="user_id" name="user_id" value="{{$userUpdate->user_id}}">
                        </div>

                        <div class="user-form">
                            <p class="sr-only">ログインパスワード</p><span class="required-form">必須</span>
                            <input type="password" class="form-control" id="password" name="password"  placeholder="パスワードを入力してください">
                        </div>
                        <div class="user-form">
                            <p class="sr-only">ログインパスワード（確認用）</p><span class="required-form">必須</span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="パスワードを入力してください（確認用）">
                        </div>
                        
                        <div class="user-form">
                            <p class="sr-only">お名前</p>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="{{$userUpdate->user_name}}">
                        </div>
                        <div class="user-form">
                            <p class="sr-only">メールアドレス</p><span class="required-form">必須</span>
                            <input type="text" class="form-control" id="email" name="email" value="{{$userUpdate->email}}">
                        </div>
                    </div>
                    <div  class="login-btn">
                        <a href="javascript:updateform.submit()">登録する</a> 
                    </div>
                </div>
            </form>
            @guest
                <div  class="login-btn">
                    <div class="etc-login-form">
                        <p><a href="{{route('auth.index')}}">ログインする</a></p>
                    </div>
                </div>
            @endguest
        </div>
        <!-- end:Main Form -->
    </div>



    <div>
@endsection

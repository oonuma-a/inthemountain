@extends('layouts.layout')
@section('css')   
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <!-- All the files that are required -->
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>

    <link href="{{asset('/css/login_style.css')}}" rel="stylesheet" />
    <script src="{{asset('/js/login_scripts.js')}}"></script>
@endsection
@section('content')
    <div class="container">
        <!-- Where all the magic happens -->
        <!-- LOGIN FORM -->
        <div class="text-center" style="padding:50px 0">
            <div class="logo">
                ログイン
            </div>
            <!-- Main Form -->
            <div class="login-form-1">
                <form id="login-form" class="text-left" name="login-form">
                    <div class="login-form-main-message">
                    </div>
                    <div class="main-login-form">
                        <div class="login-group">
                            <div class="form-group">
                                <label for="lg_username" class="sr-only">ユーザー名</label>
                                <input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="ここに入力してください。">
                            </div>
                            <div class="form-group">
                                <label for="lg_password" class="sr-only">パスワード</label>
                                <input type="password" class="form-control" id="lg_password" name="lg_password" placeholder="ここに入力してください。">
                            </div>
                            <div class="form-group login-group-checkbox">
                                <input type="checkbox" id="lg_remember" name="lg_remember">
                                <label for="lg_remember">ユーザー名とパスワードを保存する</label>
                            </div>
                        </div>
                        <div  class="login-btn">
                            <a href="javascript:login-form.submit()">ログインする</a>
                        </div>
                    </div>
                </form>
                <div  class="login-btn">
                    <div class="etc-login-form">
                        <p><a href="#">新規ユーザー登録する</a></p>
                    </div>
                </div>
            </div>
            <!-- end:Main Form -->
        </div>
    </div>
@endsection

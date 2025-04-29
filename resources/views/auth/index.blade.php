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
                <form action ="{{route('auth.index')}}" method="post" id="login-form" class="text-left" name="loginform">
                    @csrf
                    <input type="hidden" name="login_flg" value="1">
                    <div class="login-form-main-message">
                    </div>

                    <ul class="error-message-list">
                        @if (session('error')) 
                            <li>{{ session('error') }}</li>
                        @endif
                    </ul>

                    @if(!count($errors) == 0)
                        @foreach($errors as $error)
                            {{$error}}
                        @endforeach
                    @endif
                    <div class="main-login-form">
                        <div class="login-group">
                            <div class="form-group">
                                <label for="user_id" class="sr-only">ユーザーID</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="ここに入力してください。">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">パスワード</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="ここに入力してください。">
                            </div>
                        </div>
                        <div  class="login-btn">
                            <a href="javascript:loginform.submit()">ログインする</a>
                        </div>
                    </div>
                </form>
                <div  class="login-btn">
                    <div class="etc-login-form">
                        <p><a href="{{route('user.create')}}">新規ユーザー登録する</a></p>
                    </div>
                </div>
            </div>
            <!-- end:Main Form -->
        </div>
    </div>
@endsection

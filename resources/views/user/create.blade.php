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
        <!-- REGISTRATION FORM -->
        <div class="text-center" style="padding:50px 0">
            <div class="logo">ユーザー登録</div>
            <!-- Main Form -->
            <div class="login-form-1">
                <form id="register-form" class="text-left" name="registform" method="post" action="{{route('shop.index')}}">
                    @csrf
                    <input type="hidden" name="user_create_flg" value="1">
                    <div class="login-form-main-message"></div>
                    <div class="main-login-form">
                        <div class="login-group">
                            <div class="form-group">
                                <label for="user_id" class="sr-only">ログインID</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="ログインIDを入力してください">
                            </div>

                            <div class="form-group">
                                <label for="reg_password" class="sr-only">ログインパスワード</label>
                                <input type="password" class="form-control" id="reg_password" name="reg_password" placeholder="パスワードを入力してください">
                            </div>
                            <div class="form-group">
                                <label for="reg_password_confirm" class="sr-only">ログインパスワード（確認用）</label>
                                <input type="password" class="form-control" id="reg_password_confirm" name="reg_password_confirm" placeholder="パスワードを入力してください（確認用）">
                            </div>
                            
                            <div class="form-group">
                                <label for="user_name" class="sr-only">お名前</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="お名前を入力してください">
                            </div>
                            <div class="form-group">
                                <label for="reg_email" class="sr-only">メールアドレス</label>
                                <input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="メールアドレスを入力してください">
                            </div>
                            @if(isset($user_authority))
                                <div class="form-group">
                                    <label for="user_authority" class="sr-only">権限（管理者用）</label><br>
                                    <select name="user_authority" id="user_authority">
                                        <option value="0" class="form-control" >一般</option>
                                        <option value="1" class="form-control" >管理者</option>
                                    </select>
                                </div>    
                            @else
                                <input type="hidden" name="user_authority" id="user_authority" value="0">
                            @endif
                        </div>
                        <div  class="login-btn">
                            <a href="javascript:registform.submit()">登録する</a> 
                        </div>
                    </div>
                </form>
                <div  class="login-btn">
                    <div class="etc-login-form">
                        <p><a href="{{route('auth.index')}}">ログインする</a></p>
                    </div>
                </div>
            </div>
            <!-- end:Main Form -->
        </div>
    </div>



    <div>
@endsection

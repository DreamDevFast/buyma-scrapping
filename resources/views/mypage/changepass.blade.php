@extends("layouts.mypage")
@section('content')
<section class="content">
<div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>パスワード変更</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./"><i class="zmdi zmdi-home"></i> Aero</a></li>
                        <li class="breadcrumb-item">設定管理</li>
                        <li class="breadcrumb-item active">パスワード変更</li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <!-- Input -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="alert alert-warning" role="alert">
                        <strong>パスワード変更</strong>
                    </div>
                    <div class="card">
                        <div class="body">                            
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="input-group mb-3">
                                        <input type="password" id="password" class="form-control" placeholder="{{__('messages.profile.password')}}" name="password">
                                        <div class="input-group-append">                                
                                            <span class="input-group-text" id="pass-show"><i class="zmdi zmdi-lock"></i></span>
                                        </div> 
                                    </div>                                    
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-group mb-3">
                                        <input type="password" id="password_confirmation" class="form-control" placeholder="{{__('messages.profile.confirm_password')}}" name="password_confirmation">
                                        <div class="input-group-append">                                
                                            <span class="input-group-text" id="pass-show-con"><i class="zmdi zmdi-lock"></i></span>
                                        </div> 
                                    </div>                                    
                                </div>
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="save()">保管</button>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    function save(){
       
        if($("#password").val() !="" && $("#password").val() == $("#password_confirmation").val()){
            location="./changepass_check?pass="+$("#password").val();
        }else{
            alert("パスワードと確認パスワードが正しくありません。");
        }
    }
    $(document).ready(function() {        
        $("#pass-show").on('click', function(event) {

            event.preventDefault();
            if($('#password').attr("type") == "text"){
                $('#password').attr('type', 'password');                
            }else if($('#password').attr("type") == "password"){
                $('#password').attr('type', 'text');
            }
        });
        $("#pass-show-con").on('click', function(event) {

            event.preventDefault();
            if($('#password_confirmation').attr("type") == "text"){
                $('#password_confirmation').attr('type', 'password');                
            }else if($('#password_confirmation').attr("type") == "password"){
                $('#password_confirmation').attr('type', 'text');
            }
        });
    });
</script>


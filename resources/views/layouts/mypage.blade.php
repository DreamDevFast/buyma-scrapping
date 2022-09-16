<!doctype html>
<html class="no-js " lang="en">


<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
<title>:: Aero Bootstrap4 Admin :: Home</title>
<link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/charts-c3/plugin.css') }}"/>

<link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.min.css') }}" />
<!-- Custom Css -->

<link rel="stylesheet" href="{{ asset('assets/plugins/footable-bootstrap/css/footable.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/footable-bootstrap/css/footable.standalone.min.css') }}">
<link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
<style>
.l-slategray_1 {
    background: linear-gradient(0deg, #777, #28a745) !important;
    color: #fff !important;
}
</style>
</head>

<body class="theme-blush">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="assets/images/loader.svg" width="48" height="48" alt="Aero"></div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Main Search -->
<div id="search">
    <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
    <form>
      <input type="search" value="" placeholder="検索ワード入力..." id="skeyword" name="skeyword" value="<?=$skeyword?>"/>
      <button type="button" class="btn btn-primary" onclick="search()">商品検索</button>
    </form>
</div>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="./mypage"><img src="assets/images/logo.svg" width="25" alt="Aero"><span class="m-l-10">BUYMA</span></a>
    </div>
    
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html"><img src="assets/images/profile_av.jpg" alt="User"></a>
                    <div class="detail">                    
                        <h4>{{Auth::user()->family_name}}</h4>
                        <small>Super Admin</small>                        
                    </div>
                </div>
            </li>
            <li <?php if(strpos(url()->current(), "mypage"))echo 'class="active open"';?>><a href="./mypage"><i class="zmdi zmdi-home"></i><span>ダッシュボード</span></a></li>
            <li <?php if(strpos(url()->current(), "goat") || strpos(url()->current(), "louisvuitton") || strpos(url()->current(), "burberry") || strpos(url()->current(), "dior"))echo 'class="active open"';?>><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>商品管理</span></a>
                <ul class="ml-menu">
                    <li><a href="./goatpage">www.goat.com</a></li>
                    <li><a href="./louipage">it.louisvuitton.com</a></li>
                    <li><a href="./burberry">it.burberry.com</a></li>  
                    <li><a href="./dior">www.dior.com</a></li>             
                </ul>
            </li>            
            <li <?php if(strpos(url()->current(), "changepass"))echo 'class="active open"';?>><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-flower"></i><span>設定管理</span></a>
                <ul class="ml-menu">
                    <li><a href="./changepass">パスワード変更</a></li>
                </ul>
            </li>   
            <li class=""><a href="./logout"><i class="zmdi zmdi-power"></i><span>ログアウト</span></a></li>         
        </ul>
    </div>
</aside>

<!-- Right Sidebar -->
<div class="navbar-right">
    <ul class="navbar-nav">
        <li><a href="#search" class="main_search" title="商品検索..."><i class="zmdi zmdi-search"></i></a></li> 
        <!-- <li><a href="sign-in.html" class="mega-menu" title="商品追加"><i class="zmdi zmdi-assignment"></i></a></li>
        <li><a href="sign-in.html" class="mega-menu" title="CSVダウンロード"><i class="zmdi zmdi-swap-alt"></i></a></li>
        <li><a href="sign-in.html" class="mega-menu" title="ログアウト"><i class="zmdi zmdi-power"></i></a></li> -->
    </ul>
</div>

<aside id="rightsidebar" class="right-sidebar">
    <ul class="nav nav-tabs sm">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#setting"><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chat"><i class="zmdi zmdi-comments"></i></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="setting">
            <div class="slim_scroll">
                <div class="card">
                    <h6>Theme Option</h6>
                    <div class="light_dark">
                        <div class="radio">
                            <input type="radio" name="radio1" id="lighttheme" value="light" checked="">
                            <label for="lighttheme">Light Mode</label>
                        </div>
                        <div class="radio mb-0">
                            <input type="radio" name="radio1" id="darktheme" value="dark">
                            <label for="darktheme">Dark Mode</label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h6>Color Skins</h6>
                    <ul class="choose-skin list-unstyled">
                        <li data-theme="purple"><div class="purple"></div></li>
                        <li data-theme="blue"><div class="blue"></div></li>
                        <li data-theme="cyan"><div class="cyan"></div></li>
                        <li data-theme="green"><div class="green"></div></li>
                        <li data-theme="orange"><div class="orange"></div></li>
                        <li data-theme="blush" class="active"><div class="blush"></div></li>
                    </ul>                                        
                </div>
                <div class="card">
                    <h6>General Settings</h6>
                    <ul class="setting-list list-unstyled">
                        <li>
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox">
                                <label for="checkbox1">Report Panel Usage</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox2" type="checkbox" checked="">
                                <label for="checkbox2">Email Redirect</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox3" type="checkbox" checked="">
                                <label for="checkbox3">Notifications</label>
                            </div>                        
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox4" type="checkbox">
                                <label for="checkbox4">Auto Updates</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox5" type="checkbox" checked="">
                                <label for="checkbox5">Offline</label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <input id="checkbox6" type="checkbox" checked="">
                                <label for="checkbox6">Location Permission</label>
                            </div>
                        </li>
                    </ul>
                </div>                
            </div>                
        </div>       
        <div class="tab-pane right_chat" id="chat">
            <div class="slim_scroll">
                <div class="card">
                    <ul class="list-unstyled">
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar4.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Sophia <small class="float-right">11:00AM</small></span>
                                        <span class="message">There are many variations of passages of Lorem Ipsum available</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar5.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Grayson <small class="float-right">11:30AM</small></span>
                                        <span class="message">All the Lorem Ipsum generators on the</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar2.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Isabella <small class="float-right">11:31AM</small></span>
                                        <span class="message">Contrary to popular belief, Lorem Ipsum</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="me">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar1.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">John <small class="float-right">05:00PM</small></span>
                                        <span class="message">It is a long established fact that a reader</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="assets/images/xs/avatar3.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Alexander <small class="float-right">06:08PM</small></span>
                                        <span class="message">Richard McClintock, a Latin professor</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content -->
@yield('content')
<!-- Jquery Core Js --> 
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

<script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script> <!-- Sparkline Plugin Js -->
<script src="{{ asset('assets/bundles/c3.bundle.js') }}"></script>

<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/index.js') }}"></script>

<script src="{{ asset('assets/bundles/footable.bundle.js') }}"></script> 
<script src="{{ asset('assets/js/pages/tables/footable.js') }}"></script>

<script>
    $( document ).ready(function() {
    // Handler for .ready() called.
        $.ajax({
            url: './count?sel=1',
            //url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/louis/get_info?sel={{Auth::user()->id}}',
            type: 'get',
            data: {},
            success: function(msg) {
                $("#goat").html(msg+' <small class="info">of 5,000</small>');
                $("#goat_pro_txt").html(Math.floor(msg * 100 / 5000)+"%");
                $("#goat_pro").width(Math.floor(msg * 100 / 5000)+"%");
            }
        });

        $.ajax({
            url: './count?sel=2',
            //url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/louis/get_info?sel={{Auth::user()->id}}',
            type: 'get',
            data: {},
            success: function(msg) {
                $("#loui").html(msg+' <small class="info">of 5,000</small>');
                $("#loui_pro_txt").html(Math.floor(msg * 100 / 5000)+"%");
                $("#loui_pro").width(Math.floor(msg * 100 / 5000)+"%");
            }
        });

        $.ajax({
            url: './count?sel=3',
            //url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/louis/get_info?sel={{Auth::user()->id}}',
            type: 'get',
            data: {},
            success: function(msg) {
                $("#burb").html(msg+' <small class="info">of 5,000</small>');
                $("#burb_pro_txt").html(Math.floor(msg * 100 / 5000)+"%");
                $("#burb_pro").width(Math.floor(msg * 100 / 5000)+"%");
            }
        });
    });
</script>
<script>
    function add_goat_product(){        
        $("#defaultModal").modal('hide');

        $.ajax({
            //url: 'http://localhost:32768/api/v1/goats/get_info?sel={{Auth::user()->id}}',
            url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/goats/get_info?sel={{Auth::user()->id}}',
            type: 'get',
            data: {
                category: $("#category").val(),
                keyword: $("#keyword").val(),
                min_price: $("#min_price").val(),
                max_price: $("#max_price").val(),
            },
            success: function() {
                
            }
        });
		
    }
    function csv_down(sel){
        location = "./csv_down?sel="+sel;
    }
    function add_loui_product(){
        $("#defaultModal").modal('hide');
        $.ajax({
            //url: 'http://localhost:32768/api/v1/louis/get_info?sel={{Auth::user()->id}}',
            url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/louis/get_info?sel={{Auth::user()->id}}',
            type: 'get',
            data: {
                category: $("#category").val(),
                keyword: $("#keyword").val(),
                min_price: $("#min_price").val(),
                max_price: $("#max_price").val(),
            },
            success: function() {
                
            }
        });
        
    }
    function add_bur_product(){
        $("#defaultModal").modal('hide');
        $.ajax({
            //url: 'http://localhost:32768/api/v1/burs/get_info?sel={{Auth::user()->id}}',
            url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/burs/get_info?sel={{Auth::user()->id}}',
            type: 'get',
            data: {
                category: $("#category").val(),
                keyword: $("#keyword").val(),
                min_price: $("#min_price").val(),
                max_price: $("#max_price").val(),
            },
            success: function() {
                
            }
        });
        
    }

    function add_dior_product(){
        $("#defaultModal").modal('hide');
        $.ajax({
            url: 'http://localhost:32768/api/v1/dior?sel={{Auth::user()->id}}',
            // url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/dior?sel={{Auth::user()->id}}',
            type: 'get',
            data: {
                category: $("#category").val(),
                keyword: $("#keyword").val(),
                min_price: $("#min_price").val(),
                max_price: $("#max_price").val(),
            },
            success: function() {
                
            }
        });
        
    }
    localStorage.setItem('skeyword', "<?=$skeyword?>");
    function search(){
        localStorage.setItem('skeyword', $("#skeyword").val());
        location = "./goatpage?page=<?=($now_page)?>&skeyword="+localStorage.getItem("skeyword");
    }

    function exhibit_dior_product(){
        $.ajax({
            url: 'http://localhost:32768/api/v1/dior',
            // url: 'http://xs245289.xsrv.jp/fmproxy/api/v1/dior?sel={{Auth::user()->id}}',
            type: 'post',
            data: {},
            success: function() {
                
            }
        });
        
    }
</script>
</body>


</html>
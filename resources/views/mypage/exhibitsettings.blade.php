@extends("layouts.mypage")
@section('content')
<section class="content">
<div class="body_scroll">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>出品設定</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./"><i class="zmdi zmdi-home"></i> Aero</a></li>
                    <li class="breadcrumb-item">設定管理</li>
                    <li class="breadcrumb-item active">出品設定</li>
                </ul>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="body">
                <div class="row clearfix">
                    <form method="POST" action="{{route('changeExhibitSettings')}}" role="form" class="w-100" id="form">
                    @csrf
                        <div class="col-sm-6">
                            <div>Buyma手数料</div>
                            <div class="input-group mb-3">
                                <input type="text" name="commission" class="form-control" value="{{$exhibitsettings->commission}}" />
                                <div class="input-group-append">                                
                                    <span class="input-group-text" id="percentage-mark">%</span>
                                </div> 
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div>商品コメント</div>
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="comment" rows="10">{{$exhibitsettings->comment}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="button" class="btn btn-raised btn-primary btn-round waves-effect" value="保管" onclick="submit()"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
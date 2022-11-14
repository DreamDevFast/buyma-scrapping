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
						<li class="breadcrumb-item active">ユーザー情報変更</li>
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
						<strong>ユーザー情報変更</strong>
					</div>
					<div class="card">
						<div class="body">                            
							<div class="row clearfix">
								<div class="col-sm-12">
									<div class="input-group mb-3">
										<input type="text" id="user-name" class="form-control" placeholder="名前" name="user-name" value="{{$user->family_name}}">
									</div>
								</div>

								<div class="col-sm-12">
									<div class="input-group mb-3">
										<input type="eamil" id="user-email" class="form-control" placeholder="メールアドレス" name="user-email" value="{{$user->email}}">
									</div>
								</div>
								
								<div class="col-sm-12">
									<button type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="saveName()">保管</button>
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
	const saveName = () => {
		let userInfo = {
			name: $('input[name="user-name"]').val(),
			email: $('input[name="user-email"]').val()
		};
		
		$.ajax({
			url: "{{route('change_userinfo')}}",
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				postData: JSON.stringify(userInfo)
			},
			success: function () {
				toastr.success('ユーザー情報が正常に変更されました。');
			}
		});
	};
</script>

@endsection
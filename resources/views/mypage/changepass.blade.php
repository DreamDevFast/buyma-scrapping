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
										<input type="password" name="current-password" id="current-password" class="form-control" placeholder="現在のパスワード">
										<div class="input-group-append">                                
											<span class="input-group-text" onclick="showPwd(event);"><i class="zmdi zmdi-lock"></i></span>
										</div> 
									</div>                                    
								</div>
								<div class="col-sm-12">
									<div class="input-group mb-3">
										<input type="password" name="new-password" id="new-password" class="form-control" placeholder="{{__('messages.profile.password')}}">
										<div class="input-group-append">
											<span class="input-group-text" onclick="showPwd(event);"><i class="zmdi zmdi-lock"></i></span>
										</div> 
									</div>                                    
								</div>
								<div class="col-sm-12">
									<div class="input-group mb-3">
										<input type="password" name="con-password" id="con-password" class="form-control" placeholder="{{__('messages.profile.confirm_password')}}">
										<div class="input-group-append">
											<span class="input-group-text" onclick="showPwd(event);"><i class="zmdi zmdi-lock"></i></span>
										</div> 
									</div>                                    
								</div>
								<div class="col-sm-12">
									<button type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="savePass()">保管</button>
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
	const savePass = async () => {
		let curPass = $('input[name="current-password"]').val();
		let newPass = $('input[name="new-password"]').val();
		let conPass = $('input[name="con-password"]').val();

		if (curPass == '') {
			toastr.error('現在のパスワードは必須です。');
			return;
		} else if (curPass != '') {
			let confirmData = {
				password: curPass
			};

			await $.ajax({
				url: './confirm_password',
				type: 'post',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					postData: JSON.stringify(confirmData)
				},
				success: function (response) {
					// toastr.error('現在パスワードが間違っています。');
				}
			});
			// return;
		}

		if (curPass == '' && newPass != conPass) {
			toastr.error('新しいパスワードと確認パスワードが一致しません。');
			return;
		}

		$.ajax({
			url: './change_password',
			type: 'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				postData: newPass
			},
			success: function () {
				toastr.success('パスワードは正常に変更されました。');
			}
		});
	};

	const showPwd = (event) => {
		event.preventDefault();
		let passInput = $(event.target).parent().parent().prev().attr('type');
		if (passInput == 'text') {
			$(event.target).parent().parent().prev().attr('type', 'password');
		} else if (passInput == 'password') {
			$(event.target).parent().parent().prev().attr('type', 'text');;
		}
	};
</script>

@endsection
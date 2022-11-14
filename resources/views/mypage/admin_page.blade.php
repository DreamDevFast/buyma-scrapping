@extends("layouts.mypage")
@section('content')
<section class="content">
	<div class="body_scroll">
		<div class="block-header">
			<div class="row">
				<div class="col-lg-7 col-md-6 col-sm-12">
				<h2>管理者ページ</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('mypage') }}"><i class="zmdi zmdi-home"></i> Aero</a></li>
						<li class="breadcrumb-item">管理者ページ</li>
					</ul>
				</div>
				<div class="col-lg-5 col-md-6 col-sm-12">                
					<button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-12">
					<div class="card card-info card-outline">
						<div class="table-responsive">
							<table class="table table-hover product_item_list c_table theme-color mb-0">
								<thead>
									<tr>
										<th>操作</th>
										<th>ユーザー名</th>
										<th data-breakpoints="md">メール</th>
										<th data-breakpoints="xs">役割</th>  
										<th data-breakpoints="md">パーミッション</th>
									</tr>
								</thead>
								<tbody>
								@foreach($users as $user)
								@if ($user['role'] == 'admin') @continue @endif
								<tr data-id={{$user->id}}>
									<td>
										<span class="text-primary delete" onclick="deleteAccount(event);"><i class="zmdi zmdi-delete"></i></span>
									</td>
									<td rowspan="1" colspan="1">{{$user['family_name']}}</td>
									<td rowspan="1" colspan="1">{{$user['email']}}</td>
									<td rowspan="1" colspan="1">{{$user['role']}}</td>
									<td rowspan="1" colspan="1">
										<div class="form-group">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input permission" id={{"customSwitch".$user->id}} @if ($user['is_permitted']) checked @endif onchange="permitAccount(event);">
												<label class="custom-control-label" for={{"customSwitch".$user->id}}></label>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
								</tbody>
							</table>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push("scripts")
	<script>
		const deleteAccount = (event) => {
			let _tr = $(event.target).parents('tr');
			let userId = _tr.data('id');
			console.log(userId);
			$.ajax({
				url: './delete_account',
				type: 'get',
				data: {
					id: userId
				},
				success: function() {
					_tr.remove();
				}
			});
		};

		const permitAccount = (event) => {
			let isPermitted = (event.target.checked == true) ? 1 : 0;
			$.ajax({
				url: './permit_account',
				type:'get',
				data: {
					// id: event.target.id.match(/[0-9]/g)[0],
					id: event.target.id.replace('customSwitch', ''),
					isPermitted: isPermitted
				},
				success: function(response) {
					console.log(response);
				}
			});
		};
	</script>
@endpush

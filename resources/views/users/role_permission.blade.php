@extends('master')
@section('title')
Role Permission
@endsection
@section('css')
<style type="text/css">
	.tab-pane{
		height: 150px;
		overflow-y: scroll;
	}
</style>
@endsection
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Role Permission</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
						<li class="breadcrumb-item active">Home</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					@card
						@slot('title')
						<h4 class="card-title">Add New Permission</h4>
						@endslot

						<form action="{{route('users.add_permission')}}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">Name</label>
								<input type="text" name="name" class="form-control {{$errors->has('name') ? 'is-invalid':''}}" required>
								<p class="text-danger">{{$errors->first('name')}}</p>
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-sm">Add New</button>
							</div>
						</form>
						@slot('footer')
						@endslot
					@endcard
				</div>
				<div class="col-md-8">
					@card
						@slot('title')
						Set Permission Role
						@endslot
						@if(session('success'))
						@alert(['type' => 'success'])
						{!! session('success') !!}
						@endalert
						@endif
						<form action="{{route('users.role_permission')}}" method="GET">
							<div class="form-group">
								<label for="">Roles</label>
								<div class="input-group">
									<select name="role" id="" class="form-control">
										@foreach($roles as $value)
										<option value="{{ $value }}" {{ request()->get('role') == $value ? 'selected':''}}>{{$value}}</option>
										@endforeach
									</select>
									<span class="input-group-btn">
										<button class="btn btn-danger">Check!</button>
									</span>
								</div>
							</div>
						</form>
						{{-- jika $permission tidak bernilai kosong --}}
						@if(!empty($permissions))
						<form action="{{route('users.setRolePermission',request()->get('role'))}}" method="POST">
							@csrf
							@method('PUT')
							<div class="form-group">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_1" data-toggle="tab">Permission</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab_pane active" id="tab_1">
											@php $no=1; @endphp
											@foreach($permissions as $key => $row)
											<input type="checkbox" name="permission[]" class="minimal-red" value="{{$row}}"
											{{-- check , jika permission tersebut sudah diset maka , checked --}}
											{{in_array($row, $hasPermission) ? 'checked':''}}
											>{{$row}} <br>
											@if($no++%4 == 0)
											<br>
											@endif
											@endforeach
										</div>
									</div>
								</div>
							</div>
							<div class="pull-right">
								<button class="btn btn-primary btn-sm"><i class="fa fa-send"></i> Set Permissio</button>
							</div>
						</form>
						@endif
						@slot('footer')
						@endslot
					@endcard
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
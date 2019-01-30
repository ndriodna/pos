@extends('master')
@section('title')
Manajemen User
@endsection
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manajemen User</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
						<li class="breadcrumb-item active">User</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@card
						@slot('title')
						<a href="{{route('users.create')}}" class="btn btn-primary btn-sm">Tambah Baru</a>
						@endslot
						@if(session('success'))
							@alert(['type' => 'success'])
								{!! session('success') !!}
							@endalert
						@endif

						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Nama</th>
										<th>Email</th>
										<th>Role</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									@php $no=1; @endphp
									@forelse($user as $row)
									<tr>
										<td>{{$no++}}</td>
										<td>{{$row->name}}</td>
										<td>{{$row->email}}</td>
										<td>
											@foreach($row->getRoleNames() as $role)
											<label for="" class="badge badge-info">{{$role}}</label>
											@endforeach
										</td>
										<td>
											@if($row->status)
											<label for="" class="badge badge-success">Aktif</label>
											@else
											<label for="" class="badge badge-default">Suspend</label>
											@endif
										</td>
										<td>
											<form action="{{route('users.destroy',$row->id)}}" method="POST">
												@csrf
												@method('DELETE')
												<a href="{{route('users.roles',$row->id)}}" class="btn btn-info btn-sm"><i class="fa fa-user-secret"></i></a>
												<a href="{{route('users.edit',$row->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
												<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
											</form>
										</td>
									</tr>
									@empty
									<tr>
										<td colspan="4" class="text-center">Tidak Ada Data</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						@slot('footer')
						@endslot
					@endcard
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@extends('master')
@section('title')
Edit Product
@endsection
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit data</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item"><a href="{{route('produk.index')}}">Produk</a></li>
						<li class="breadcrumb-item active">Edit</li>
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
						@endslot

						@if(session('success'))
							@alert(['type' => 'success'])
								{!! session('success') !!}
							@endalert
						@endif
						<form action="{{route('produk.update',$products->id)}}" method="POST" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="form-group">
								<label for="">Kode Produk</label>
								<input type="text" name="code" required maxlength="10" readonly value="{{$products->code}}" class="form-control {{$errors->has('code') ? 'is-invalid':''}}">
								<p class="text-danger">{{$errors->first('code')}}</p>
							</div>
							<div class="form-group">
								<label for="">Nama Produk</label>
								<input type="text" name="name" required value="{{$products->name}}" class="form-control {{$errors->has('name') ? 'is-invalid':''}}">
								<p class="text-danger">{{$errors->first('name')}}</p>
							</div>
							<div class="form-group">
								<label for="">Deskripsi</label>
								<textarea name="description" id="description" cols="5" rows="5" class="form-control {{$errors->has('description') ? 'is-invalid':''}}">{{$products->description}}</textarea>
								<p class="text-danger">{{$errors->first('description')}}</p>
							</div>
							<div class="form-group">
								<label for="">Stok</label>
								<input type="text" name="stock" required value="{{$products->stock}}" class="form-control {{$errors->has('stock') ? 'is-invalid':''}}">
								<p class="text-danger">{{$errors->first('stock')}}</p>
							</div>
							<div class="form-group">
								<label for="">Harga</label>
								<input type="text" name="price" required value="{{$products->price}}" class="form-control {{$errors->has('price') ? 'is-invalid':''}}">
								<p class="text-danger">{{$errors->first('price')}}</p>
							</div>
							<div class="form-group">
								<label for="">Katergori</label>
								<select name="category_id" id="category_id" required class="form-control {{$errors->has('price') ? 'is-invalid':''}}">
									<option value="">Pilih</option>
									@foreach($categories as $row)
									<option value="{{$row->id}}" {{$row->id == $products->category_id ? 'selected':""}}>{{ucfirst($row->name)}}</option>
									@endforeach
								</select>
								<p class="text-danger">{{$errors->first('category_id')}}</p>
							</div>
							<div class="form-group">
								<label for="">Foto</label>
								<input type="file" name="photo" required class="form-control">
								<p class="text-danger">{{$errors->first('photo')}}</p>
								@if(!empty($products->photo))
								<hr>
								<img src="{{asset('uploads/product/' .$products->photo)}}" alt="{{$products->name}}" width="150px" height="150px">
								@endif
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i>Update</button>
							</div>
						</form>
						@slot('footer')

						@endslot
					@endcard
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
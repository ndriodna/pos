<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use File;
use Image;

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::orderBy('created_at','DESC')->paginate(10);
    	return view('products.index',compact('products'));
    }

    public function create()
    {
    	$categories = Category::orderBy('name','ASC')->get();
    	return view('products.create',compact('categories'));
    }

 		private function saveFile($name, $photo)
 		{
			//set nama file adalah gabungan antara nama produk dan time(). Ekstensi gambar tetap dipertahankan
			$images = str_slug($name) . time() . '.' . $photo->getClientOriginalExtension();
			//set path untuk menyimpan gambar
			$path = public_path('uploads/product');
			//cek jika uploads/product bukan direktori / folder
			if (!File::isDirectory($path)) {
				File::makeDirectory($path,0777,true,true);
			}
			//simpan gambar yang diuplaod ke folrder uploads/produk
			Image::make($photo)->save($path . '/' . $images);
			//mengembalikan nama file yang ditampung divariable $images
			return $images;
 		}

 		public function store(Request $request)
 		{
 			// melakuakan validasi data
	   	$this->validate($request,[
	   		'code' => 'required|string|max:10|unique:products',
	   		'name' => 'required|string|max:100',
	   		'description' => 'nullable|string|max:100',
	   		'stock' => 'required|integer',
	   		'price' => 'required|integer',
	   		'category_id' => 'required|exists:categories,id',
	   		'photo' => 'nullable|image|mimes:jpg,png,jpeg' //mimes adalah extensi yang di perbolehkan 
	   	]);

	   	try {
	   		// default $photo = null
	   		$photo = null;
	   		// jika teradapat file yang dikirmi
	   		if ($request->hasFile('photo')) {
	   			// maka run method saveFile , method saveFIle adalah method buatan sendiri
	   			$photo = $this->saveFile($request->name,$request->file('photo'));
	   		} 

	   		//menyimpan data ke dalam database degan method create 
	   		$products = Product::create([
					'code' => $request->code,
					'name' => $request->name,
					'description' => $request->description,
					'stock' => $request->stock,
					'price' => $request->price,
					'category_id' => $request->category_id,
					'photo' => $photo,
	   		]);
	   		// jika data berhasil disimpan maka akan redirect ke index dan akan muncul notif (namadata) ditambahakan
	   		return redirect(route('produk.index'))->with(['success'=>'<strong>'.$products->name . '</strong> DiTambahkan']);
	   	} catch (Exception $e) {
	   		// jika gagal akan redirect kembali lalu error tampil
	   		return redirect()->back()->with(['error' => $e->getMessage()]);
	   	}	
 		}

 		public function edit($id)
 		{
 			$products = Product::findOrFail($id);
 			$categories = Category::orderBy('name','ASC')->get();
 			return view('products.edit',compact('products','categories'));
 		}
 		public function update(Request $request,$id)
 		{
 			$this->validate($request,[
 				'code' => 'required|string|max:10|exists:products,code',
	   		'name' => 'required|string|max:100',
	   		'description' => 'nullable|string|max:100',
	   		'stock' => 'required|integer',
	   		'price' => 'required|integer',
	   		'category_id' => 'required|exists:categories,id',
	   		'photo' => 'nullable|image|mimes:jpg,png,jpeg'
 			]);

 			try {
 				$product = Product::findOrFail($id);
 				$photo = $product->photo;

 				if ($request->hasFile('photo')) {
 					!empty($photo)?File::delete(public_path('uploads/product'.$photo)):null;
 					$photo = $this->saveFile($request->name,$request->file('photo'));
 				}

 					$product->update([
					'name' => $request->name,
					'description' => $request->description,
					'stock' => $request->stock,
					'price' => $request->price,
					'category_id' => $request->category_id,
					'photo' => $photo,
 				]);
 					return redirect(route('produk.index'))->with(['success' => '<strong>'. $product->name.'</strong> Diperbarui']);
 			} catch (Exception $e) {
 				return redirect()->back()->with(['error'=>$e->getMessage()]);
 			}
 		}

 		public function destroy($id)
 		{
 			$products = Product::findOrFail($id);
 			if (!empty($products->photo)) {
 				File::delete(public_path('uploads/product'.$products->photo));
 			}
 			$products->delete();
 			return redirect()->back()->with(['success'=>'<strong>'. $products->name. '</strong> DiHapus']);
 		}
}

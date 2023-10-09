<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::all();

        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required'];
            $rules += [$locale . '.description' => 'required'];
        }

        $rules += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];

        $request->validate($rules);

        $request_date =  $request->except('image');
        if ($request->image) {
            $img = Image::make($request->image);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/' . $request->image->hashName()));

            $request_date['image'] = $request->image->hashName();
        }

        Product::create($request_date);

        return redirect()->route('dashboard.products.index')->with('success', 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);

        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $rules = [
            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required'];
            $rules += [$locale . '.description' => 'required'];
        }

        $rules += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];

        $request->validate($rules);

        $request_date =  $request->except('image');

        if ($request->image) {
            if ($product->image != 'default.jpg') {
                Storage::disk('public_path')->delete('users_images/' . $product->image);
            }
            $img = Image::make($request->image);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/' . $request->image->hashName()));

            $request_date['image'] = $request->image->hashName();
        }
        $product->update($request_date);
        return redirect()->route('dashboard.products.index')->with('success', 'Product updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image   != 'default.jpg') {
            Storage::disk('public_path')->delete('products_images/' . $product->image);
        }
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('success', 'product Deleted Successfully');
    }
}

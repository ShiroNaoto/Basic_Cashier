<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Sale, SaleItem, Product, Cart, Ship};

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $carts = Cart::all();

        $itemCount = $carts->count();

        return view('products.index', [
            'products' => $products,
            'carts' => $carts,
            'itemCount' => $itemCount,
        ]);
    }

    public function create()
    {
        $carts = Cart::all();

        $itemCount = $carts->count();

        return view('products.create', [
            'carts' => $carts,
            'itemCount' => $itemCount,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');

            $data['image'] = str_replace('images/', '', $imagePath);
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $carts = Cart::all();
        $itemCount = $carts->count();

        return view('products.update', [
            'product' => $product,
            'carts' => $carts,
            'itemCount' => $itemCount,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('images/' . $product->image);
            }

            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');

            $data['image'] = str_replace('images/', '', $imagePath);
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('products.index')->with('success', 'Item has been removed from your cart!');
    }
}

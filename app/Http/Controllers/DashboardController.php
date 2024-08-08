<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Sale, SaleItem, Product, Cart, Ship};

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $carts = Cart::all();

        $itemCount = $carts->count();

        return view('dash', [
            'products' => $products,
            'carts' => $carts,
            'itemCount' => $itemCount,
        ]);
    }


    public function addCart(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'prodid' => 'required|numeric',
        ]);

        $total = $request->quantity * $request->price;

        Cart::create([
        'prodid' => $request->prodid,
        'price' => $total,
        'quantity' => $request->quantity,
        ]);

        return redirect('/')->with('success', 'Added to cart');
    }
}

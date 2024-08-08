<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Sale, SaleItem, Product, Cart, Ship};
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        $itemCount = $carts->count();
        $sales = Sale::with('saleItems.product')->get();
        return view('sales.index', compact('sales', 'carts', 'itemCount'));
    }

    public function create()
    {
        $carts = Cart::all();
        $itemCount = $carts->count();
        $products = Product::all();
        return view('sales.create', compact('products', 'carts', 'itemCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $sale = Sale::create(['total_amount' => 0]);

            $totalAmount = 0;

            foreach ($request->products as $productData) {
                $product = Product::find($productData['id']);
                $quantity = $productData['quantity'];
                $price = $product->price * $quantity;

                $product->update(['stock' => $product->stock - $quantity]);

                $sale->saleItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $totalAmount += $price;
            }

            $sale->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

}

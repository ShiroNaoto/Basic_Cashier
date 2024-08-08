<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Sale, SaleItem, Product, Cart, Ship};
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        $itemCount = $carts->count();
        $totalSum = $carts->sum('price');

        return view('carts.cartlist', [
            'carts' => $carts,
            'itemCount' => $itemCount,
            'totalSum' => $totalSum,
        ]);
    }

    public function destroy($id)
    {
        Cart::destroy($id);
        return redirect()->route('carts.index')->with('success', 'Item has been removed from your cart!');
    }

    public function checkout()
    {
        $carts = Cart::all();
        $itemCount = $carts->count();
        $totalSum = $carts->sum('price');

        return view('carts.checkout', [
            'carts' => $carts,
            'itemCount' => $itemCount,
            'totalSum' => $totalSum,
        ]);
    }

    public function orderlist()
    {
        $carts = Cart::all();
        $itemCount = $carts->count();
        $ships = Ship::all();

        // Group shipments by exact date and time
        $groupedShips = $ships->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d H:i:s'); // Group by exact timestamp
        })->map(function ($group) {

            // Aggregate products within each timestamp group
            $productAggregations = $group->groupBy('prodid')->map(function ($items) {
                return [
                    'product' => $items->first()->product,
                    'quantity' => $items->sum('quantity'),
                    'totalPrice' => $items->sum('price'),
                ];
            });

            return [
                'products' => $productAggregations,
                'totalDatePrice' => $group->sum('price')
            ];
        });

        return view('carts.orderlist', [
            'carts' => $carts,
            'itemCount' => $itemCount,
            'groupedShips' => $groupedShips,
        ]);
    }

    public function processCheckout(Request $request)
{
    $validatedData = $request->validate([
        'payment_method' => 'required|in:cash_on_delivery,gcash',
        'discount' => 'nullable|numeric|min:0|max:100',
    ]);

    $paymentMethod = $validatedData['payment_method'];
    $discountPercentage = $validatedData['discount'] ?? 0;
    $carts = Cart::all();

    $totalSum = $carts->sum('price');

    $discountAmount = ($discountPercentage / 100) * $totalSum;

    $ordersData = $carts->map(function ($cart) use ($paymentMethod, $discountAmount, $totalSum) {
        $itemDiscount = ($discountAmount / $totalSum) * $cart->price;

        $discountedPrice = $cart->price - $itemDiscount;
        if ($discountedPrice < 0) {
            $discountedPrice = 0; 
        }

        return [
            'prodid' => $cart->prodid,
            'quantity' => $cart->quantity,
            'price' => $discountedPrice,
            'discount' => $itemDiscount,
            'payment_method' => $paymentMethod,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    })->toArray();

    DB::table('ships')->insert($ordersData);
    Cart::truncate();

    return redirect()->route('carts.index')->with('success', 'Order placed successfully!');
}

}

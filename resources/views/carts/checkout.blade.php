@extends('layout')

@section('content')
<div class="container">
    <h1>Checkout</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carts as $cart)
                <tr>
                    <td>{{ $cart->product->name }}</td>
                    <td>{{ $cart->quantity }}</td>
                    <td>$ {{ $cart->price }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="text-right"><strong>Total:</strong></td>
                <td>$ {{ $totalSum }}</td>
            </tr>
        </tbody>
    </table>
    <form action="{{ route('processCheckout') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="cash_on_delivery" required>
                    <label class="form-check-label" for="cash_on_delivery">
                        Cash on Delivery
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="gcash" value="gcash" required>
                    <label class="form-check-label" for="gcash">
                        Gcash Payment
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="discount">Discount: %</label>
            <input type="number" name="discount" id="discount" class="form-control" min="0" step="0.01" placeholder="Enter discount percentage">
        </div>

        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-bell"></i> Proceed to Checkout</button>
    </form>
</div>
@endsection

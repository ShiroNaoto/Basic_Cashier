@extends('layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Your Cart</h1>
            </div>
        </div>
    </div>
</div>

<div class="callout callout-success">
    <h5>Order Summary</h5>
    <p>Subtotal ({{$itemCount}} items)<b> ${{$totalSum}}</b></p>
    <p>Shipping Fee</p>
    <div class="col-md-2">
        <form action="{{ route('checkout') }}" method="GET">
        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-bell"></i> Proceed to Checkout</button>
    </form>
    </div>
</div>

<div class="card-body table-responsive p-0" style="height: 500px;">
    <table class="table table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($carts->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">Your cart is empty!</td>
                </tr>
            @else
                @foreach($carts as $cart)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/images/' . $cart->product->image) }}" 
                                 alt="{{ $cart->product->name }}" 
                                 title="{{ $cart->product->name }}" 
                                 style="max-width: 100px; max-height: 100px;" />
                        </td>
                        <td>{{ $cart->product->name }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>$ {{ $cart->price }}</td>
                        <td>
                            <button type="button" class="btn btn-block btn-danger btn-sm" data-toggle="modal" data-target="#destroyCart{{$cart->id}}">Remove Item</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- Delete Function Modal -->
@foreach($carts as $cart)
    <div class="modal fade" id="destroyCart{{$cart->id}}">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('carts.destroy', $cart->id) }}" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Item</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this item?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-light">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
@endsection

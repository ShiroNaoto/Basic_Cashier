@extends('layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Your Orders</h1>
            </div>
        </div>
    </div>
</div>

<div class="card-body table-responsive">
    <table class="table table-head-fixed table-striped table-bordered">
        <thead>
            <tr>
                <th>Date and Time</th>
                <th>Product Details</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($groupedShips as $timestamp => $data)
                <tr>
                    <td>{{ $timestamp }}</td>
                    <td>
                        @foreach($data['products'] as $product)
                            <div class="product-info mb-2">
                                @if($product['product'])
                                    <p>{{ $product['product']->name }} - {{ $product['quantity'] }} units</p>
                                @else
                                    <p>Product no longer available - {{ $product['quantity'] }} units</p>
                                @endif
                            </div>
                        @endforeach
                    </td>
                    <td>${{ $data['totalDatePrice'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No Orders!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

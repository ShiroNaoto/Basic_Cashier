@extends('layout')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sales List</h1>
          </div>

          <div class="col-sm-6">
            <div class="breadcrumb float-sm-right">
                <button type="button" onclick="window.location.href='{{ route('sales.create') }}'" class="btn btn-block btn-primary btn-lg" ><i class="fa fa-plus-circle mr-1"></i>Create Sales</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ul>
        @foreach($sales as $sale)
            <li>
                Sale #{{ $sale->id }} - ${{ $sale->total_amount }}
                <ul>
                    @foreach($sale->saleItems as $item)
                        <li>{{ $item->product->name }} - ${{ $item->price }} - Quantity: {{ $item->quantity }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
@endsection

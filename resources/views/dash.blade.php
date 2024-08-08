@extends('layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->   
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title">Items Available</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                        @foreach($products as $product)
                            <div class="col-sm-2">
                                <a href="#" data-toggle="modal" data-target="#viewItem{{ $product->id }}">
                                    <img src="{{ asset('storage/images/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         title="{{ $product->name }}" 
                                         class="product-image" 
                                    />
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @foreach($products as $product)
    <div class="modal fade" id="viewItem{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="viewItemLabel{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewItemLabel{{ $product->id }}">{{$product->name}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="prodid" id="prodid{{ $product->id }}" value="{{ $product->id }}">

                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/images/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            title="{{ $product->name }}" 
                            class="product-image img-fluid" 
                            style="max-width: 200px; max-height: 200px;" />
                    </div>

                    <div class="text-center mb-3">
                        <h1>${{$product->price}}</h1>
                        <p>Stock Remaining: {{$product->stock}}</p>
                    </div>

                    <form action="{{ route('addCart') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3" style="max-width: 150px; margin: auto;">
                            <input type="number" class="form-control" name="quantity" value="1">
                        </div>
                        <input type="hidden" name="prodid" value="{{ $product->id }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add to cart</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection

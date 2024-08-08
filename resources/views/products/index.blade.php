@extends('layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Product List</h1>
            </div>

            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    <button type="button" onclick="window.location.href='{{ route('products.create') }}'" class="btn btn-block btn-primary btn-lg">
                        <i class="fa fa-plus-circle mr-1"></i>Add Product
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-body table-responsive p-0" style="height: 600px;">
    <table class="table table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{ asset('storage/images/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         title="{{ $product->name }}" 
                         style="max-width: 100px; max-height: 100px;" 
                    />
                </td>
                <td>{{ $product->name }}</td>
                <td>$ {{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success">Action</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Update</a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#removeModal{{ $product->id }}">Remove Item</a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($products as $product)
<!-- Remove Item Modal -->
<div class="modal fade" id="removeModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeModalLabel{{ $product->id }}">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

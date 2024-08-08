@extends('layout')

@section('content')
    <h1>Create Sale</h1>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div id="products">
            @foreach($products as $product)
                <div>
                    <label>{{ $product->name }} - ${{ $product->price }} - Stock: {{ $product->stock }}</label>
                    <input type="number" name="products[{{ $loop->index }}][quantity]" min="1" placeholder="Quantity">
                    <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
                </div>
            @endforeach
        </div>
        <button type="submit">Create Sale</button>
    </form>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Products</h2>
        </div>
        @can('manage-products')
        <div class="col-auto">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
        </div>
        @endcan
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                        <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                            {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row g-2">
                        <div class="col">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info w-100">Details</a>
                        </div>
                        @can('manage-products')
                        <div class="col">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning w-100">Edit</a>
                        </div>
                        <div class="col">
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->isEmpty())
    <div class="alert alert-info">
        No products available.
    </div>
    @endif
</div>
@endsection 
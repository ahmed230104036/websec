@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center mb-4">Welcome to Our Store</h1>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 text-center">
                            <p class="lead">
                                Discover our amazing products and enjoy secure shopping with us.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h2 class="mb-4">Featured Products</h2>
        </div>
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
                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection 
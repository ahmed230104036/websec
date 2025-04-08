@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Products') }}</span>
                        @auth
                            @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add Product') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($products->isEmpty())
                        <p class="text-center">No products found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;">Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        @auth
                                            @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
                                                <th>Actions</th>
                                            @endif
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                @if ($product->image_path)
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                                         alt="{{ $product->name }}" 
                                                         style="width: 180px; height: auto;"
                                                         class="img-thumbnail">
                                                @else
                                                    <span class="text-muted">No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                                    {{ $product->stock > 0 ? 'Available' : 'Out of Stock' }}
                                                </span>
                                            </td>
                                            @auth
                                                @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('products.edit', $product) }}" 
                                                               class="btn btn-primary btn-sm">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form action="{{ route('products.destroy', $product) }}" 
                                                                  method="POST" 
                                                                  class="d-inline" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>
                                                        @if($product->stock > 0)
                                                            <form action="{{ route('products.buy', $product) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm">
                                                                    <i class="fas fa-shopping-cart"></i> {{ __('Buy Now') }}
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-secondary btn-sm" disabled>
                                                                <i class="fas fa-ban"></i> {{ __('Out of Stock') }}
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endif
                                            @endauth
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Product Image" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    var modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>
@endsection
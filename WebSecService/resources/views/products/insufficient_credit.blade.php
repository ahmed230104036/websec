@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    {{ __('Insufficient Credit') }}
                </div>

                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">{{ __('Unable to Complete Purchase') }}</h4>
                        <p>{{ __('You do not have enough credit to purchase this product.') }}</p>
                        <hr>
                        <p class="mb-0">
                            {{ __('Your current credit balance') }}: ${{ number_format(auth()->user()->credit, 2) }}<br>
                            {{ __('Product price') }}: ${{ number_format($product->price, 2) }}<br>
                            {{ __('Additional credit needed') }}: ${{ number_format($product->price - auth()->user()->credit, 2) }}
                        </p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            {{ __('Back to Products') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
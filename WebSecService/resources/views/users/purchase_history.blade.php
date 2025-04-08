@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Purchase History') }}</div>

                <div class="card-body">
                    @if($purchases->isEmpty())
                        <p class="text-center">No purchase history found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->product->name }}</td>
                                            <td>${{ number_format($purchase->price_at_purchase, 2) }}</td>
                                            <td>{{ $purchase->quantity }}</td>
                                            <td>${{ number_format($purchase->price_at_purchase * $purchase->quantity, 2) }}</td>
                                            <td>{{ $purchase->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('profile') }}" class="btn btn-secondary">
                            {{ __('Back to Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
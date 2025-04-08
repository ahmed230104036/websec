@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Role:</strong> 
                        @if($user->hasRole('Admin'))
                            <span class="badge bg-danger">Admin</span>
                        @elseif($user->hasRole('Employee'))
                            <span class="badge bg-primary">Employee</span>
                        @elseif($user->hasRole('Customer'))
                            <span class="badge bg-success">Customer</span>
                        @else
                            <span class="badge bg-secondary">No Role Assigned</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Permissions:</strong><br>
                        @if($user->hasRole('Admin'))
                            - Can manage all products<br>
                            - Can manage employees<br>
                            - Can manage customers
                        @elseif($user->hasRole('Employee'))
                            - Can manage products<br>
                            - Can manage customers
                        @elseif($user->hasRole('Customer'))
                            - Can view products<br>
                            - Can make purchases
                        @endif
                    </div>

                    @if($user->isCustomer())
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Credit Balance') }}</label>
                            <div class="col-md-6">
                                <p class="form-control-static">${{ number_format($user->credit, 2) }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('purchase_history') }}" class="btn btn-primary">
                                    {{ __('View Purchase History') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($user->isSeller())
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    {{ __('Add New Product') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-secondary">
                                {{ __('Edit Profile') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
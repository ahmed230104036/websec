@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome to WebSecService') }}</div>

                <div class="card-body">
                    @guest
                        <p>Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a> to continue.</p>
                    @else
                        <p>Welcome back, {{ Auth::user()->name }}!</p>
                        @if (Auth::user()->isCustomer())
                            <p>Your current credit: {{ Auth::user()->credit }}</p>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

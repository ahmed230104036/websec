@extends('layouts.master')
@section('title', 'Customers')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Customers</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card mt-2">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->credit ?? 0 }}</td>
                    <td>
                        <a href="{{ route('employees.add_credit', $customer) }}" class="btn btn-primary">Add Credit</a>
                        <a href="{{ route('employees.credit_history', $customer) }}" class="btn btn-info">Credit History</a>
                        <a href="{{ route('employees.reset', $customer) }}" class="btn btn-warning" onclick="return confirm('Are you sure you want to reset this customer\'s credit?')">Reset Credit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.master')
@section('title', 'Credit History')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Credit History for {{ $user->name }}</h1>
    </div>
    <div class="col col-2">
        <a href="{{ route('employees.customers') }}" class="btn btn-primary form-control">Back to Customers</a>
    </div>
</div>

<div class="card mt-2">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $record)
                <tr>
                    <td>{{ $record->created_at }}</td>
                    <td>{{ ucfirst($record->type) }}</td>
                    <td>{{ $record->amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 
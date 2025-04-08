@extends('layouts.master')
@section('title', 'Add Credit')
@section('content')
<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <form action="{{ route('employees.add_credit', $user) }}" method="post">
            @csrf
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                <strong>Error!</strong> {{$error}}
            </div>
            @endforeach

            <div class="row mb-2">
                <div class="col-12">
                    <h3>Add Credit for {{ $user->name }}</h3>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Amount:</label>
                    <input type="number" class="form-control" placeholder="Amount" name="amount" min="0" step="0.01" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Credit</button>
            <a href="{{ route('employees.customers') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection 
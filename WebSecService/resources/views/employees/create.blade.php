@extends('layouts.master')
@section('title', 'Add Employee')
@section('content')
<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <form action="{{ route('employees.store') }}" method="post">
            @csrf
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                <strong>Error!</strong> {{$error}}
            </div>
            @endforeach

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" required>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection 
@extends('layouts.master')
@section('title', 'Edit Employee')
@section('content')
<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <form action="{{ route('employees.update', $employee) }}" method="post">
            @csrf
            @method('PUT')
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                <strong>Error!</strong> {{$error}}
            </div>
            @endforeach

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $employee->name }}" required>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $employee->email }}" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if ($reset->isEmpty())
                        <p class="text-center">The Credit Balance is reseted.</p>
                    @else
                        <div class="table-responsive">
                            <p class="text-center">Reset it</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
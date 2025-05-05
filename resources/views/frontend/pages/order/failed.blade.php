@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">Payment Failed</div>

                <div class="card-body text-center">
                    <h4 class="text-danger mb-4">Payment Failed</h4>
                    <p>{{ $error ?? 'There was an issue processing your payment.' }}</p>
                    <p>Please try again or contact support.</p>
                    
                    <a href="{{ route('cart') }}" class="btn btn-primary mt-4">
                        Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
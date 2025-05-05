@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">Order Successful</div>

                <div class="card-body text-center">
                    <h4 class="text-success mb-4">Thank you for your order!</h4>
                    <p>Your payment was successful.</p>
                    <p>Payment ID: {{ $payment_id ?? '' }}</p>
                    
                    <a href="{{ url('/') }}" class="btn btn-primary mt-4">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
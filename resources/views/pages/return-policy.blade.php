@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-4">Return Policy</h1>
                <p class="text-muted mb-4">Last updated: {{ date('F d, Y') }}</p>

                <div class="mb-4">
                    <h4 class="fw-bold">1. Returns</h4>
                    <p class="text-secondary">You have 30 calendar days to return an item from the date you received it. To
                        be eligible for a return, your item must be unused and in the same condition that you received it.
                    </p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">2. Refunds</h4>
                    <p class="text-secondary">Once we receive your item, we will inspect it and notify you that we have
                        received your returned item. If your return is approved, we will initiate a refund to your original
                        method of payment.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">3. Shipping</h4>
                    <p class="text-secondary">You will be responsible for paying for your own shipping costs for returning
                        your item. Shipping costs are non-refundable.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">4. Contact Us</h4>
                    <p class="text-secondary">If you have any questions on how to return your item to us, contact us.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

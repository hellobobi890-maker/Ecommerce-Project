@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Checkout</h2>

            <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Contact information</h2>

                        <div class="mt-4">
                            <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input type="email" id="email-address" name="email" autocomplete="email"
                                    value="{{ auth()->user()->email }}" disabled
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-100">
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <div class="mt-1">
                                    <input type="text" name="address" id="address" autocomplete="street-address"
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <div class="mt-1">
                                    <input type="text" name="city" id="city" autocomplete="address-level2"
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal code</label>
                                <div class="mt-1">
                                    <input type="text" name="postal_code" id="postal_code" autocomplete="postal-code"
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <div class="mt-1">
                                    <input type="tel" name="phone" id="phone" autocomplete="tel" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Payment</h2>

                        <fieldset class="mt-4">
                            <legend class="sr-only">Payment type</legend>
                            <div class="space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                                <div class="flex items-center">
                                    <input id="cod" name="payment_type" type="radio" checked
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">Cash on
                                        Delivery</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <!-- Order summary -->
                <div class="mt-10 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                    <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                        <h3 class="sr-only">Items in your cart</h3>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach ($cart as $details)
                                <li class="flex px-4 py-6 sm:px-6">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $details['image'] ?? 'https://tailwindui.com/plus/img/ecommerce-images/checkout-page-04-product-01.jpg' }}"
                                            alt="" class="w-20 rounded-md">
                                    </div>

                                    <div class="ml-6 flex flex-1 flex-col">
                                        <div class="flex">
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-sm">
                                                    <a href="#"
                                                        class="font-medium text-gray-700 hover:text-gray-800">{{ $details['name'] }}</a>
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="flex flex-1 items-end justify-between pt-2">
                                            <p class="mt-1 text-sm font-medium text-gray-900">
                                                ${{ number_format($details['price'], 2) }}</p>
                                            <p class="mt-1 text-sm font-medium text-gray-500">Qty {{ $details['quantity'] }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    ${{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900">$5.00</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                <dt class="text-base font-medium">Total</dt>
                                <dd class="text-base font-medium text-gray-900">
                                    ${{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']) + 5, 2) }}
                                </dd>
                            </div>
                        </dl>

                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <button type="submit"
                                class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Confirm
                                Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

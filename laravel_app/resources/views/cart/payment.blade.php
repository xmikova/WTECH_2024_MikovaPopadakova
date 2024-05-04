@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/payment.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="title-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>Platba</h2>
                </div>
            </div>
        </div>
    </section>

    <form id="paymentForm" action="{{ route('payment.order') }}"  method="POST">
        @csrf
        <section class="payment-type-container mt-5 col-md-6 mx-auto">
            <div class="container row mb-3 justify-content-center">
                <div class="row mb-5">
                    <div class="col-md-6 mx-auto">
                        <h3>Druh platby</h3>
                        <!-- Loop through payment methods retrieved from the database -->
                        @foreach($payments as $payment)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentType" id="{{ $payment->type }}" value="{{ $payment->type }}">
                                <label class="form-check-label" for="{{ $payment->type }}">
                                    {{ $payment->type }} @if($payment->price > 0) - {{ $payment->price }} €@endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="payment-container mt-5 mb-5 col-md-6 mx-auto">
            <div class="container justify-content-center text-center">
                <div class="row mt-3">
                    <div class="col-md-6 mx-auto">
                        <div class="mt-3">
                            <h3>Zvolili ste:</h3>
                            <p id="selectedPayment">(zvolený druh platby)</p>
                            <p>info</p>
                            <p class="text-break">______________________________________________</p>
                            <p class="text-break">______________________________________________</p>
                            <p class="text-break">______________________________________________</p>
                            <div class="buyNow ms-lg-3 text-center mt-5">
                                <p>Celková suma: €</p>
                                <button type="submit" id="order-button" class="btn btn-outline-dark p-3">Objednať s povinnosťou platby</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection


@section('customJs')
    <script>
        // Add event listener to payment radio buttons
        document.querySelectorAll('input[name="paymentType"]').forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {
                // Update the selected payment display with the selected value
                document.getElementById('selectedPayment').innerText = this.value;
            });
        });
    </script>@endsection

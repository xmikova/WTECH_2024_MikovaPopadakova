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
                            <p id="selectedPayment">(tu sa zobrazí zvolený druh platby a informácie)</p>
                            <p id="info_osobne" class="payment-info text-break" style="display: none;">Vybrali ste si platbu osobne pri prevzatí zásielky na predajni.
                                Zásielku je možné uhradiť v hotovosti alebo kartou. Doručenie na predajňu vám
                                bude oznámené SMS správou a emailom.</p>
                            <p id="info_kartou" class="payment-info text-break" style="display: none;">Vybrali ste si platbu kartou online. Po kliknutí tlačidla budete
                                presmerovaný do platobnej brány kde zadaním svojich bankových údajov môžete zaplatiť
                                objednávku. Potvrdenie o prijatí platby vám bude zaslané mailom.</p>
                            <p id="info_dobierka" class="payment-info text-break" style="display: none;">Vybrali ste si platbu na dobierku. Zásielku vám doručí kuriér,
                                ktorý vám ju vydá po zaplatení hotovosťou. Pri dobierke nie je možné platiť kartou.</p>
                            <div class="buyNow ms-lg-3 text-center mt-5">
                                <h5>Celková suma: {{ $totalPrice }}€</h5>
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
        document.querySelectorAll('input[name="paymentType"]').forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {

                document.getElementById('selectedPayment').innerText = " ";

                document.querySelectorAll('.payment-info').forEach(function(info) {
                    info.style.display = 'none';
                });

                document.getElementById('info_' + this.value).style.display = 'block';
            });
        });
    </script>
@endsection

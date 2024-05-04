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

    <form id="paymentForm" action="{{ route('payment.store') }}"  method="POST">
        @csrf
        <section class="payment-type-container mt-5 col-md-6 mx-auto">
            <div class="container row mb-3 justify-content-center">
                <div class="row mb-5">
                    <div class="col-md-6 mx-auto">
                        <h3>Druh platby</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentType" id="personalcollection" value="personalcollection">
                            <label class="form-check-label" for="personalcollection">
                                pri prevzatí (osobný odber)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentType" id="cashondelivery" value="cashondelivery">
                            <label class="form-check-label" for="cash on delivery">
                                dobierka - 1 €
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentType" id="card" value="card">
                            <label class="form-check-label" for="card">
                                kartou online
                            </label>
                        </div>
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
                            <p>(zvolený druh platby)</p>
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

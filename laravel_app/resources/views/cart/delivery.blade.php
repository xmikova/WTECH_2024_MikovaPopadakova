@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/delivery.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="title-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center ">
                    <h2>Doručenie a údaje</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="delivery-container mt-5 col-md-6 mx-auto">
        <div class="container row mb-3 justify-content-center">
            <div class="row mb-5 ">
                <div class="col-md-6 mx-auto">
                    <h3>Fakturačné údaje</h3>
                    <div class="mb-3">
                        <label for="billingName" class="form-label">Meno a Priezvisko</label>
                        <input type="text" class="form-control" id="billingName" placeholder="Meno a Priezvisko">
                    </div>
                    <div class="mb-3">
                        <label for="billingAddress" class="form-label">Adresa</label>
                        <input type="text" class="form-control" id="billingAddress" placeholder="Adresa">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="billingZip" class="form-label">PSČ</label>
                            <input type="text" class="form-control" id="billingZip" placeholder="PSČ">
                        </div>
                        <div class="col">
                            <label for="billingCity" class="form-label">Mesto</label>
                            <input type="text" class="form-control" id="billingCity" placeholder="Mesto">
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="billingPhone" class="form-label">Telefónne číslo</label>
                            <input type="tel" class="form-control" id="billingPhone" placeholder="Telefónne číslo">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="sameAddress">
                            <label class="form-check-label" for="sameAddress">Dodacia adresa je rovnaká</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Dodacie údaje</h3>
                    <div class="mb-3">
                        <label for="shippingName" class="form-label">Meno a Priezvisko</label>
                        <input type="text" class="form-control" id="shippingName" placeholder="Meno a Priezvisko">
                    </div>
                    <div class="mb-3">
                        <label for="shippingAddress" class="form-label">Adresa</label>
                        <input type="text" class="form-control" id="shippingAddress" placeholder="Adresa">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="shippingZip" class="form-label">PSČ</label>
                            <input type="text" class="form-control" id="shippingZip" placeholder="PSČ">
                        </div>
                        <div class="col">
                            <label for="shippingCity" class="form-label">Mesto</label>
                            <input type="text" class="form-control" id="shippingCity" placeholder="Mesto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="delivery-container mb-5 mt-5 col-md-6 mx-auto">
        <div class="container row mb-3 justify-content-center">
            <div class="row mb-5">
                <div class="col-md-6 mx-auto">
                    <h3>Typ dopravy</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="shippingType" id="personalPickup" value="personalPickup">
                        <label class="form-check-label" for="personalPickup">
                            Osobný odber - zdarma
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="shippingType" id="zBox" value="zBox">
                        <label class="form-check-label" for="zBox">
                            Z-BOX - 3 €
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="shippingType" id="courier" value="courier">
                        <label class="form-check-label" for="courier">
                            Kurier - 3,50 €
                        </label>
                    </div>
                </div>
                <div class="col-md-6" id="storeSelection" style="display: none;">
                    <h3>Výber predajne</h3>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="storeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Vyber predajňu
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="storeDropdown">
                            <li><a class="dropdown-item" href="#" data-value="Bratislava">Bratislava</a></li>
                            <li><a class="dropdown-item" href="#" data-value="Košice">Košice</a></li>
                            <li><a class="dropdown-item" href="#" data-value="Žilina">Žilina</a></li>
                            <li><a class="dropdown-item" href="#" data-value="Nitra">Nitra</a></li>
                            <li><a class="dropdown-item" href="#" data-value="Trnava">Trnava</a></li>
                        </ul>
                    </div>
                </div>
                <div class="buyNow ms-lg-3 text-center mt-5">
                    <button class="btn btn-outline-dark" onclick="window.location.href = 'payment.html';">Platba</button>
                </div>
            </div>
        </div>
    </section>
@endsection

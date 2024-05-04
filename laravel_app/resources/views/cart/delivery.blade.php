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

    <form id="deliveryForm" action="{{ route('delivery.store') }} " method="POST">
        @csrf
        <section class="delivery-container mt-5 col-md-6 mx-auto">
            <div class="container row mb-3 justify-content-center">
                <div class="row mb-5 ">
                    <div class="col-md-6 mx-auto">
                        <h3>Fakturačné údaje</h3>
                        <div class="mb-3">
                            <label for="billing_name" class="form-label">Meno a Priezvisko</label>
                            <input type="text" class="form-control" name="factural_name" id="factural_name"  placeholder="Meno a Priezvisko">
                        </div>
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Adresa</label>
                            <input type="text" class="form-control" name="factural_address" id="factural_address"  placeholder="Adresa">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="billing_postal_code" class="form-label">PSČ</label>
                                <input type="text" class="form-control" name="factural_postal_code" id="factural_postal_code"  placeholder="PSČ">
                            </div>
                            <div class="col">
                                <label for="billing_city" class="form-label">Mesto</label>
                                <input type="text" class="form-control" name="factural_city" id="factural_city"  placeholder="Mesto">
                            </div>
                        </div>
                        <div>
                            <div class="mb-3">
                                <label for="billing_phone_number" class="form-label">Telefónne číslo</label>
                                <input type="tel" class="form-control" name="factural_phone_number" id="factural_phone_number" placeholder="Telefónne číslo">
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
                            <label for="factural_name" class="form-label">Meno a Priezvisko</label>
                            <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="Meno a Priezvisko">
                        </div>
                        <div class="mb-3">
                            <label for="factural_address" class="form-label">Adresa</label>
                            <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Adresa">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="factural_postal_code" class="form-label">PSČ</label>
                                <input type="text" class="form-control" name="billing_postal_code" id="billing_postal_code" placeholder="PSČ">
                            </div>
                            <div class="col">
                                <label for="factural_city" class="form-label">Mesto</label>
                                <input type="text" class="form-control" name="billing_city" id="billing_city" placeholder="Mesto">
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
                        <button type="submit" id="payment-button" class="btn btn-outline-dark p-3">Platba</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

@section('customJs')
    <script>
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const selectedValue = this.getAttribute('data-value');
                document.getElementById('storeDropdown').innerText = selectedValue;
            });
        });

        document.querySelectorAll('input[name="shippingType"]').forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {
                if (this.value === 'personalPickup' && this.checked) {
                    document.getElementById('storeSelection').style.display = 'block'; // Show the store selection
                } else {
                    document.getElementById('storeSelection').style.display = 'none'; // Hide the store selection
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select the form element
            var form = document.getElementById('deliveryForm');

            // Add form submission event listener
            form.addEventListener('submit', function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Create a new FormData object to store form data
                var formData = new FormData(form);

                // Submit the form data asynchronously using AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        // Check if the form submission was successful
                        if (response.ok) {
                            // Redirect the user to the payment page
                            window.location.href = "{{ route('payment.index') }}";
                        } else {
                            // Handle errors if any
                            console.error('Form submission failed:', response.statusText);
                        }
                    })
                    .catch(error => {
                        // Handle any network errors
                        console.error('Error occurred during form submission:', error);
                    });
            });
        });
    </script>
@endsection

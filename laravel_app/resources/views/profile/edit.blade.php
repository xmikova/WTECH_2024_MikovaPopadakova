@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/user.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="title-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>Vitaj, {{ Auth::user()->name }}!</h2>
                    <p>
                        V tejto časti si viete prezrieť svoje objednávky, či aktualizovať svoje osobné údaje.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <div class="row align-items-center justify-content-center mx-auto">
            <div class="button-part col-md-4 col-sm-6 text-center mb-3">
                <button id="myOrdersBtn" class="btn btn-outline-dark">Moje objednávky</button>
            </div>
            <div class="button-part col-md-4 col-sm-6 text-center mb-3">
                <button id="myDataBtn" class="btn btn-outline-dark">Moje údaje</button>
            </div>
            <div class="button-part col-md-4 col-sm-6 text-center mb-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" id="logOutBtn" class="btn btn-outline-dark">Odhlásiť sa</button>
                </form>
            </div>
        </div>
    </div>

    <section class="user-items mt-xl-5 me-xl-5 ms-xl-5 mb-xl-5">
        <div id="myOrders" class="container mt-4 mb-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-6 text-start">
                        <p class="order-info">Objednávka č.123</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="order-status">Stav: vytvorená</p>
                    </div>
                </div>
                <div class="scrollable-container">
                    <div class="scrollable-content d-flex">
                      hello
                    </div>
                </div>
                <div class="navigation-arrows">
                    <button class="prev-btn">&lt;</button>
                    <button class="next-btn">&gt;</button>
                </div>
            </div>
        </div>
        <div id="myData" class="container mt-4 mb-lg-5" style="display: none;">
            <section class="add-data-container mb-5 col-md-6 mx-auto text-center">
                <div class="mt-3 mb-5">
                    <div class="col text-center">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
                <div class="mt-5">
                    <div class="col text-center">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        const myOrdersBtn = document.querySelector('#myOrdersBtn');
        const myDataBtn = document.querySelector('#myDataBtn');

        const myOrdersSection = document.querySelector('#myOrders');
        const myDataSection = document.querySelector('#myData');

        myOrdersBtn.addEventListener('click', () => {
            myOrdersSection.style.display = 'block';
            myDataSection.style.display = 'none';
        });

        myDataBtn.addEventListener('click', () => {
            myOrdersSection.style.display = 'none';
            myDataSection.style.display = 'block';
        });

        document.querySelector('.prev-btn').addEventListener('click', function() {
            document.querySelector('.scrollable-container').scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        document.querySelector('.next-btn').addEventListener('click', function() {
            document.querySelector('.scrollable-container').scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });
    </script>
@endsection



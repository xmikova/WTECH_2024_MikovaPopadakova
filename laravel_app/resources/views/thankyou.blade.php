@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/orderfinal.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="thank-you-container mt-5 me-5 ms-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h4>Ďakujeme za vašu objednávku!</h4>
                    <p>
                        Vaša objednávka bola úspešne zaznamenaná. Ďalšie informácie vám budú doručené mailom.
                    </p>
                    <div class="back-to-homepage">
                        <a href="{{ route('landing') }}" class="btn btn-outline-dark">Vrátiť sa na domovskú stránku</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

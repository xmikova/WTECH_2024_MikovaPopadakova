@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/landingpage.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="favorite-categories mt-xl-5 me-xl-5 ms-xl-5">
    <div class="container">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h4>Najobľúbenejšie kategórie</h4>
        </div>
    </div>
    <div class="row justify-content-center text-center">
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('products.category', ['category' => 'obaly-na-telefon']) }}" class="text-decoration-none text-dark">
                <div class="category-item">
                    <img src="{{ asset('images/kategorie/telefon_kategoria.png') }}" alt="Obaly na telefón" class="img-fluid ">
                    <p class="mt-2">Obaly na telefón</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('products.category', ['category' => 'obaly-na-sluchadla']) }}" class="text-decoration-none text-dark">
                <div class="category-item">
                    <img src="{{asset('images/kategorie/sluchadla_kategoria.jpg') }}" alt="Obaly na slúchadlá" class="img-fluid">
                    <p class="mt-2">Obaly na slúchadlá</p>
                </div>
            </a>
        </div>
        <div class="w-100 d-md-none"></div>
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('products.category', ['category' => 'ochranne-folie-a-skla']) }}"  class="text-decoration-none text-dark">
                <div class="category-item">
                    <img src="{{ asset('images/kategorie/sklo_kategoria.jpg') }}" alt="Ochranné fólie a sklá" class="img-fluid">
                    <p class="mt-2">Ochranné fólie a sklá</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('products.category', ['category' => 'obaly-na-laptop']) }}"  class="text-decoration-none text-dark">
                <div class="category-item">
                    <img src="{{ asset('images/kategorie/laptop_kategoria.jpg') }}" alt="Obaly na laptop" class="img-fluid">
                    <p class="mt-2">Obaly na laptop</p>
                </div>
            </a>
        </div>
    </div>
    </div>
    </section>

    <section class="product-of-the-week mt-xl-5 me-xl-5 ms-xl-5">
        <div class="container">
            <div class="row align-items-center">
                <h2 class="hit text-center mb-4">˗ˏˋ★ˎˊ˗ HIT TÝŽDNA ˗ˏˋ★ˎˊ˗</h2>
                <div class="col-md-6 text-center">
                    <div class="hit-picture ms-xl-5">
                        <img src="{{ asset('images/products/telefon/telefon_modry.jpg') }}" alt="Product of the Week" class="img-fluid" style="width: 350px; height:auto;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="hit-description">
                        <a class="text-decoration-none text-dark">
                            <h3>Názov produktu</h3>
                        </a>
                        <p class="text-break">Popis produktu bude tuto:</p>
                        <p class="text-break">______________________________________________</p>
                        <p class="text-break">______________________________________________</p>
                        <p class="text-break">______________________________________________</p>
                        <div class="buy-now">
                            <h5 class="mb-0">Cena: XX.XX€</h5>
                            <a class="btn btn-outline-dark ps-4 pe-4">KÚPIŤ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="recommended-items mt-xl-5 me-xl-5 ms-xl-5 mb-xl-5">
        <div class="container">
            <div class="text-center mb-3">
                <h4>Vybrali sme pre vás</h4>
            </div>
            <div class="scrollable-container">
                <div class="scrollable-content d-flex">
                    @foreach($randomProducts as $product)
                        <div class="product-card">
                            <a href="{{ route('products.show', ['productId' => $product->id]) }}">
                                <div class="product-image">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width: 200px; height: auto;">
                                </div>
                                <div class="product-info">
                                    <p>{{ $product->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="navigation-arrows">
                <button class="prev-btn">&lt;</button>
                <button class="next-btn">&gt;</button>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
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



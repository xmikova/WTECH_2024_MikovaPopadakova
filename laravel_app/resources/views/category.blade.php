@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/productcategory.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="category-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h4>
                        @if($category->id === 1)
                            Obaly na telefón
                        @elseif($category->id === 2)
                            Obaly na slúchadlá
                        @endif
                    </h4>
                    <p>
                        @if($category->id === 1)
                            Vyberte si zo širokej škaly obalov na telefón.
                        @else
                            {{ ucfirst($category->name) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="filters container mt-4 mb-lg-5">
            <form method="get" action="{{  route('products.category', ['category' => $category->name]) }}">
                <div class="row align-items-center justify-content-center mx-auto">
                    <div class="filter-part col-md-2">
                        <select class="form-select" id="phoneTypeSelect" name="device_type">
                            <option value="" disabled selected>Typ telefónu</option>
                            @foreach($deviceTypes as $deviceType)
                                <option value="{{ $deviceType }}">{{ $deviceType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-part col-md-2">
                        <select class="form-select" id="colorSelect" name="color">
                            <option value="" disabled selected>Farba</option>
                            @foreach($colors as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-part col-md-2">
                        <select class="form-select" id="sortSelect" name="sort_by">
                            <option value="" disabled selected>Usporiadať</option>
                            <option value="lowest">Najnižšia cena</option>
                            <option value="highest">Najvyššia cena</option>
                        </select>
                    </div>
                    <div class="filter-part col-md-2" style="display: flex; align-items: center;">
                        <label for="minPrice" class="mr-1" style="margin-bottom: 0; margin-right: 10px">Cena od:</label>
                        <input type="number" class="form-control" style="width: 100px" id="minPrice" name="min_price" value="{{ $minPrice }}" min="{{ $minPrice }}" max="{{ $maxPrice }}">
                    </div>
                    <div class="filter-part col-md-2" style="display: flex; align-items: center;">
                        <label for="maxPrice" class="mr-1" style="margin-bottom: 0; margin-right: 10px">Cena do:</label>
                        <input type="number" class="form-control" style="width: 100px" id="maxPrice" name="max_price" value="{{ $maxPrice }}" min="{{ $minPrice }}" max="{{ $maxPrice }}">
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="button-part col-md-2">
                        <button class="btn btn-outline-dark btn-block" id="resetFiltersBtn">Obnoviť filtre</button>
                    </div>
                    <div class="button-part col-md-2">
                        <button type="submit" class="btn btn-outline-dark btn-block">Filtruj</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($products as $product)
                <div class="col">
                    <a href="{{ route('products.show', ['productId' => $product->id]) }}" class="card text-decoration-none">
                        <img src="{{ asset($product->images->first()->image_path) }}" class="card-img" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }} €</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="pagination">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        document.getElementById('resetFiltersBtn').addEventListener('click', function() {
            const baseUrl = window.location.href.split('?')[0];
            window.location.href = baseUrl;
        });
    </script>
@endsection

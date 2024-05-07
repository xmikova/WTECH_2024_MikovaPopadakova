@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/admintools.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="title-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>Vitaj, admin!</h2>
                    <p>
                        Tu môžete spravovať e-shop - pridávať, upravovať, či mazať produkty.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <div class="row align-items-center justify-content-center mx-auto">
            <div class="button-part col-md-4 col-sm-6 text-center mb-3">
                <button id="productManagementBtn" class="btn btn-outline-dark">Správa produktov</button>
            </div>
            <div class="button-part col-md-4 col-sm-6 text-center mb-3">
                <button id="addProductBtn" class="btn btn-outline-dark">Pridanie produktu</button>
            </div>
            <div class="button-part col-md-4 col-sm-6 text-center mb-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" id="logOutBtn" class="btn btn-outline-dark">Odhlásiť sa</button>
                </form>
            </div>
        </div>
    </div>

    <div id="productManagement" class="container mt-4 mb-lg-5">
        <div class="container">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach($products as $product)
                        <div class="col">
                            <a href="{{ route('products.show', ['productId' => $product->id]) }}" class="card text-decoration-none">
                                <img src="{{ asset($product->images->first()->image_path) }}" class="card-img" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text bi bi-pencil" style="font-size: larger;"> EDIT</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <div id="addProductForm" class="container mt-4 mb-lg-5" style="display: none;">
        <h4 class="text-center mb-4">
            Zadajte detaily produktu:
        </h4>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="add-product-container mb-5 col-md-6 mx-auto text-center">
            @csrf
            <div class="mt-3">
                <div class="mt-3">
                    <div class="mb-3">
                        <input type="text" name="name" class="add-form form-control me-3" placeholder="Názov produktu">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="device_type" class="add-form form-control me-3" placeholder="Typ produktu">
                    </div>
                    <div class="mb-3">
                        <textarea name="description" class="add-form form-control me-3" placeholder="Popis"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="brand" class="add-form form-control me-3" placeholder="Značka">
                    </div>
                    <div class="mb-3">
                        <input type="number" step="0.01" name="price" class="add-form form-control me-3" placeholder="Cena">
                    </div>
                    <div class="mb-3">
                        <p>Je to hit týždňa?</p>
                        <input type="radio" id="yes" name="weekly_hit" value="1">
                        <label for="yes">Ano</label><br>
                        <input type="radio" id="no" name="weekly_hit" value="0">
                        <label for="no">Nie</label><br>
                    </div>
                    <div class="mb-3">
                        <p>Kategória:</p>
                        <select name="category_id">
                            <option value="1">Obaly na telefón</option>
                            <option value="2">Obaly na slúchadlá</option>
                            <option value="3">Ochranné fólie a sklá</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p>Farba:</p>
                        <select name="color">
                            <option value="červená">Červená</option>
                            <option value="modrá">Modrá</option>
                            <option value="zelená">Zelená</option>
                            <option value="žltá">Žltá</option>
                            <option value="oranžová">Oranžová</option>
                            <option value="fialová">Fialová</option>
                            <option value="ružová">Ružová</option>
                            <option value="hnedá">Hnedá</option>
                            <option value="čierna">Čierna</option>
                            <option value="béžová">Béžová</option>
                        </select>
                    </div>
                    <div class="mb-3 input-group-append">
                        <p>Nahrať fotografie:</p>
                        <input type="file" name="image[]" class="add-form form-control" id="inputGroupFile01" multiple>
                    </div>
                </div>
                <div class="buyNow">
                    <button type="submit" class="btn btn-outline-dark text-center px-lg-5">Pridať</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('customJs')
    <script>
        const productManagementBtn = document.querySelector('#productManagementBtn');
        const addProductBtn = document.querySelector('#addProductBtn');

        const productManagementSection = document.querySelector('#productManagement');
        const addProductFormSection = document.querySelector('#addProductForm');

        productManagementBtn.addEventListener('click', () => {
            productManagementSection.style.display = 'block';
            addProductFormSection.style.display = 'none';
        });

        addProductBtn.addEventListener('click', () => {
            productManagementSection.style.display = 'none';
            addProductFormSection.style.display = 'block';
        });

    </script>
@endsection

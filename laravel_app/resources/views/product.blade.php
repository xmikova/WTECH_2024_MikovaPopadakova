@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/productdetails.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="container py-4">
        <div class="main-container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset($product->images()->first()->image_path) }}" id="main-image" alt="Product Image" class="img-fluid mb-3">
                    </div>
                    <div class="d-flex justify-content-center">
                        @foreach($product->images()->skip(1)->take(3)->get() as $image)
                            <img src="{{ asset($image->image_path) }}" class="thumbnail img-fluid me-2" alt="Thumbnail Image">
                        @endforeach
                    </div>

                    @if(Auth::user() && Auth::user()->role === 'admin')
                        <div class="mt-3 ms-5">
                            <h5>Obrázky produktu:</h5>
                            <ul>
                                @foreach($product->images as $image)
                                    <li class="mb-3">
                                        <span>{{ $image->image_path }}</span>
                                        <form action="{{ route('product.image.delete', ['productId' => $product->id, 'imageId' => $image->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Odstrániť</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                            <form action="{{ route('product.image.upload', ['productId' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 me-5 mt-3">
                                    <label for="image" class="form-label">Nahrajte nový obrázok:</label>
                                    <div class="d-flex">
                                        <input type="file" class="form-control me-2" id="image" name="image" style="width: 400px">
                                        <button type="submit" class="btn btn-outline-dark">Nahrať</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="description">
                        @auth
                            @if(Auth::user() && Auth::user()->role === 'admin')
                                <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <h3 class="mb-3 mt-lg-4">Úprava produktu:</h3>
                                    <div class="mb-3 me-5">
                                        <label for="name" class="form-label">Názov produktu:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                                    </div>
                                    <div class="mb-3 me-5">
                                        <label for="description" class="form-label">Popis produktu:</label>
                                        <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                                    </div>
                                    <div class="mb-3 me-5">
                                        <label for="price" class="form-label">Cena produktu:</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}">
                                    </div>
                                    <div class="mb-3 me-5">
                                        <label for="color" class="form-label">Farba produktu:</label>
                                        <input type="text" class="form-control" id="color" name="color" value="{{ $product->color }}">
                                    </div>
                                    <div class="mb-3 me-5">
                                        <label for="brand" class="form-label">Značka produktu:</label>
                                        <input type="text" class="form-control" id="brand" name="brand" value="{{ $product->brand }}">
                                    </div>
                                    <div class="mb-3 me-5">
                                        <label for="device_type" class="form-label">Typ zariadenia:</label>
                                        <input type="text" class="form-control" id="device_type" name="device_type" value="{{ $product->device_type }}">
                                    </div>
                                    <button type="submit" class="btn btn-outline-dark">Uložiť</button>
                                </form>
                                <form action="{{ route('product.delete', ['product' => $product->id]) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Odstrániť produkt</button>
                                </form>
                            @else
                                <h1 class="mb-3 mt-lg-4">{{ $product->name }}</h1>
                                <p class="mb-3">{{ $product->description }}</p>
                                <h4 class="mb-3">Cena: {{ $product->price }}€</h4>

                                <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" id="add-to-cart" class="btn btn-outline-dark p-3">Pridať do košíka</button>
                                </form>
                            @endif
                        @else
                            <h1 class="mb-3 mt-lg-4">{{ $product->name }}</h1>
                            <p class="mb-3">{{ $product->description }}</p>
                            <h4 class="mb-3">Cena: {{ $product->price }}€</h4>
                            <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST">
                                @csrf
                                <button type="submit" id="add-to-cart" class="btn btn-outline-dark p-3">Pridať do košíka</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        document.addEventListener("DOMContentLoaded", function() {
            const mainImage = document.getElementById("main-image");
            const thumbnails = document.querySelectorAll(".thumbnail");

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener("click", function() {
                    // Save the current main image source
                    const mainImageSrc = mainImage.src;

                    // Set the main image source to the clicked thumbnail source
                    mainImage.src = thumbnail.src;

                    // Set the clicked thumbnail source to the previous main image source
                    thumbnail.src = mainImageSrc;
                });
            });
        });
    </script>
@endsection

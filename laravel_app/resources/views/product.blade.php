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
                        <img src="{{ asset($product->image) }}" id="main-image" alt="Product Image" class="img-fluid mb-3">
                    </div>
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset($product->image) }}" class="thumbnail img-fluid me-2" alt="Thumbnail Image 1">
                        <img src="{{ asset($product->image) }}" class="thumbnail img-fluid me-2" alt="Thumbnail Image 2">
                        <img src="{{ asset($product->image) }}" class="thumbnail img-fluid me-2" alt="Thumbnail Image 3">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="description">
                        <h1 class="mb-3 mt-lg-4">{{ $product->name }}</h1>
                        <p class="mb-3">{{ $product->description }}</p>
                        <h4 class="mb-3">Cena: {{ $product->price }}€</h4>

                        <!-- Check if the user is an admin -->
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description:</label>
                                        <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                                    </div>
                                    <!-- Add more fields as needed -->

                                    <button type="submit" class="btn btn-outline-dark">Save</button>
                                </form>
                            @else

                            @endif
                        @endauth
                        <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" id="add-to-cart" class="btn btn-outline-dark p-3">Pridať do košíka</button>
                        </form>
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
                    mainImage.src = thumbnail.src;
                });
            });
        });
    </script>
@endsection

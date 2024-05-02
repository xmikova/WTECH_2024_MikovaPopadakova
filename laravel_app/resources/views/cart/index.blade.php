@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/shoppingbasket.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="title-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>Nákupný košík</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="basket-container mt-5 mt-xl-5 me-xl-5 ms-xl-5">
        <div class="container">
            @if($cartItems->isEmpty())
                <div class="row mb-3 justify-content-center">
                    <div class="col text-center">
                        <p>The basket is empty.</p>
                    </div>
                </div>
            @else
                @foreach($cartItems as $cartItem)
                    @php
                        // Retrieve the product
                        $product = \App\Models\Product::find($cartItem['product_id']);
                    @endphp
                    <div class="product-background row mb-3 border rounded">
                        <div class="div_img col-2">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                        </div>
                        <div class="div_text col-8">
                            <h5><a href="{{ route('products.show', $product->id) }}" class="product-link">{{ $product->name }}</a></h5>
                            <p>{{ $product->description }}</p>
                            <p>Cena: {{ $product->price }}€</p>
                        </div>
                        <div class="div_button col-2 d-flex flex-column justify-content-around align-items-center">
                            <form action="{{ route('cart.update', $product->id) }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-outline-dark increment-btn" data-product-id="{{ $product->id }}">+</button>
                            </form>
                            <span type="number" id="quantity-{{ $product->id }}" name="quantity">{{ $cartItem['quantity'] }}</span>
                            <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-dark">-</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="row mb-3 justify-content-center">
                    <div class="buyNow ms-lg-3 text-center">
                        <h5>Celková cena: {{ $totalPrice }}€</h5>
                        <form action="" method="POST">
                            @csrf
                            <button type="submit" id="add-to-cart" class="btn btn-outline-dark p-3" >Pokračovať k doprave</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        // Add event listener to all increment buttons
        document.querySelectorAll('.increment-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get the corresponding quantity input field
                const productId = this.getAttribute('data-product-id');
                const quantityInput = document.getElementById(`quantity-${productId}`);

                // Increment the quantity
                quantityInput.value = parseInt(quantityInput.value) + 1;

                // Trigger form submission
                const form = button.closest('form');
                form.submit();
            });
        });
    </script>
@endsection




@extends('layouts.app')

@section('content')
    <section class="category-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h4>{{ ucfirst($category) }}</h4>
                    <!-- You can add a description of the category here -->
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($products as $product)
                <div class="col">
                    <a href="{{ route('product.details', ['id' => $product->id]) }}" class="card text-decoration-none">
                        <img src="{{ asset($product->image) }}" class="card-img" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

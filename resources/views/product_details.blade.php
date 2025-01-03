@extends('header') <!-- Assuming you have a layout for user-side -->

@section('section')

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/product_details.css') }}"> <!-- Link to your custom CSS -->

<div class="container mt-5">

    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2>{{ $product->ProductName }}</h2>
            <hr>
        </div>
    </div>

    <!-- Product Details Section -->
    <div class="row">
        <!-- Left Column: Product Images -->
        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="product-images">
                <!-- Main Product Image -->
                @php
                    $image = $product->images->first();
                @endphp
                @if($image) 
                    <img src="{{ asset('Products/'.$image->productimage) }}" alt="Product Image" class="img-fluid main-image" style="width: 100%; height: auto;">
                @else
                    <img src="{{ asset('Products/default.jpg') }}" alt="Default Image" class="img-fluid main-image" style="width: 100%; height: auto;">
                @endif

                <!-- Thumbnail Images -->
                <div class="thumbnail-images mt-3">
                    @foreach($product->images as $image)
                        <img src="{{ asset('Products/'.$image->productimage) }}" alt="Product Image" class="img-fluid thumbnail" style="cursor: pointer;" onclick="changeMainImage('{{ asset('Products/'.$image->productimage) }}')">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Product Information -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="product-info">
                <!-- Price -->
                <p class="price">&#8377;{{ number_format($product->productprice, 2) }}</p>

                <!-- Category -->
                <p class="category"><strong>Category:</strong> {{ optional($product->category)->categoryname ?? 'Uncategorized' }}</p>

                <!-- ProductName -->
                <p class="brand"><strong>Product Name:</strong> {{ $product->productname ?? 'N/A' }}</p>

                <!-- Brand -->
                <p class="brand"><strong>Brand:</strong> {{ $product->brand ?? 'N/A' }}</p>

                <!-- Model Number -->
                {{-- <p class="model-number"><strong>Model Number:</strong> {{ $product->ModelNumber ?? 'N/A' }}</p> --}}

                <!-- Warranty Period -->
                <p class="warranty"><strong>Warranty:</strong> {{ $product->warrantyperiod ?? 'N/A' }}</p>

                <!-- Status -->
                <p class="status">
                    @if($product->status == 'Active')
                        <span class="badge badge-success">Available</span>
                    @else
                        <span class="badge badge-danger">Unavailable</span>
                    @endif
                </p>

                <!-- Description -->
                <p class="description">{{ $product->description ?? 'No description available.' }}</p>

                <!-- Add to Cart Button -->
                <button class="btn btn-primary btn-lg add-to-cart">
                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                </button>

                <!-- Buy Now Button -->
                <button class="btn btn-success btn-lg buy-now mt-3">
                    <i class="fa-solid fa-basket-shopping"></i> Buy Now
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    // Function to change the main image on thumbnail click
    function changeMainImage(src) {
        document.querySelector('.main-image').src = src;
    }
</script>

@endsection

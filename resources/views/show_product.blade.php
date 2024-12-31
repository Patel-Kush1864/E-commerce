@extends('header') <!-- Assuming you have a layout for user-side -->

@section('section')

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/show_product.css') }}"> <!-- Link to your custom CSS -->

@if(session('success'))
<script>
    alert("{{ session('success') }}");
    window.location.href = "{{ route('Register.index') }}";
</script>
@endif

@if(session('success_addcart'))
<script>
    alert("{{ session('success_addcart') }}");
    window.location.href = "{{ route('Register.index') }}";
</script>
@endif

@if(session('info'))
<script>
    alert("{{ session('info') }}");
    window.location.href = "{{ route('Register.index') }}";
</script>
@endif


@if(session('success_wishlist'))
<script>
    alert("{{ session('success_wishlist') }}");
    window.location.href = "{{ route('Register.index') }}";
</script>
@endif

@if(session('error'))
<script>
    alert("{{ session('error') }}");
    redirectToLogin();
</script>
@endif

<div class="container mt-5">

    <!-- Logout Section (Top Right Corner or Header) -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>

    <!-- Header Section -->
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2>Our Products</h2>
            <hr>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <form action="" method="GET" class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search for products.." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> Search
                </button>
            </form>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm position-relative">
                @php
                    // Get the first image associated with the product
                    $image = $product->images->first(); // Get the first associated image
                @endphp
    
                @if($image) 
                    <img src="{{ asset('Products/'.$image->ProductImage) }}" 
                            alt="Product Image" 
                            class="card-img-top img-fluid" 
                            style="height: 250px; object-fit: cover;">
                @else
                    <img src="{{ asset('Products/default.jpg') }}" 
                            alt="Default Image" 
                            class="card-img-top img-fluid" 
                            style="height: 250px; object-fit: cover;">
                @endif
               
                <!-- Like Icon (Top Right Corner) -->
                <a href="{{ route('cart.heart',$product->Prod_id) }}"  class="btn btn-danger btn-sm like-button position-absolute" 
                style="top: 10px; right: 10px; z-index: 10;"><i class="fa-regular fa-heart"></i></a>

                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->ProductName }}</h5>
                    <p class="card-text text-muted">
                        {{ optional($product->category)->Cate_Name ?? 'Uncategorized' }}
                    </p>
                    <p class="card-text">
                        <strong>&#8377;{{ number_format($product->ProductPrice, 2) }}</strong>
                    </p>
                    <p>
                        @if($product->Status == 'Active')
                            <span class="badge badge-success">Available</span>
                        @else
                            <span class="badge badge-danger">Unavailable</span>
                        @endif
                    </p>

                    <!-- Add to Cart Button -->
                    {{-- <button class="btn btn-outline-success btn-sm add-to-cart" data-product-id="{{ $product->id }}">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                    </button> --}}

                    <!-- Add to Cart Button -->
                    <a href="{{ route('cart.addtocart',$product->Prod_id) }}" class="btn btn-outline-success btn-sm add-to-cart"><i class="fa-solid fa-cart-plus"></i>Add to Cart</a>

                    <!-- View Details Button -->
                    <a href="{{ route('Product.show',$product->Prod_id) }} " class="btn btn-outline-success btn-sm">
                        <i class="fa-solid fa-eye"></i> View Details
                    </a>

                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

@endsection

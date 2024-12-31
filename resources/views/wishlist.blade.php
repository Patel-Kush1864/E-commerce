@extends('header')

@section('section')
<link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
<div class="container wishlist-container">
    
@if(session('success'))
<script>
    alert("{{ session('success') }}");
    window.location.href = "{{ route('wishlist.show') }}";
</script>
@endif
    <h1 class="text-center">Your Wishlist</h1>
    <div class="row">
        @forelse ($wishlistItems as $item)
            <div class="col-md-6 col-lg-4">
                <div class="wishlist-card">
                    <div class="row">
                        <div class="col-12">
                            @php
                                $image = $item->product->images->first();
                            @endphp
                            @if($image)
                                <img src="{{ asset('Products/'.$image->ProductImage) }}" 
                                     alt="{{ $item->product->ProductName }}" 
                                     class="product-image">
                            @else
                                <img src="{{ asset('Products/default.jpg') }}" 
                                     alt="Default Image" 
                                     class="product-image">
                            @endif
                        </div>
                        <div class="col-12 text-center">
                            <h2 class="product-title">{{ $item->product->ProductName }}</h2>
                            <p class="product-price">&#8377;{{ number_format($item->product->ProductPrice, 2) }}</p>
                            <div class="btn-action">
                                <a href="" class="btn btn-primary btn-sm">View Product</a>
                                <a href="{{ route('wishlist.remove', $item->product->Prod_id) }}" class="btn btn-danger btn-sm">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Your wishlist is empty.</p>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

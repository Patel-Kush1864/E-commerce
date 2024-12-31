@extends('admin_header')

@section('section')

<link rel="stylesheet" href="{{ asset('css/admin_showproduct.css') }}">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card admin-form-card">
                <div class="card-header text-center">
                    Manage Products
                </div>

                <div class="card-body">
                    <!-- Success/Error Message Display -->
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Product Grid -->
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card product-card">
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
                                {{-- <img src="{{ asset('Products/'.$product->ProductImage) }}" alt="Product Image" class="card-img-top img-fluid" style="height: 250px; object-fit: cover;"> --}}
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->ProductName }}</h5>
                                    <p class="card-text">{{ optional($product->category)->Cate_Name ?? 'N/A' }}
                                    </p>
                                    <p class="card-text"><strong>&#8377;{{ number_format($product->ProductPrice, 2) }}</strong></p>
                                    <p class="card-text"><strong>Stock :- {{ $product->ProductStock }}</strong></p>
                                    <p class="card-text">
                                        @if($product->Status == 'Active')
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="#" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

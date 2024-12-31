@extends('header')

@section('section')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

@if(session('success'))
<script>
    alert("{{ session('success') }}");
    window.location.href = "{{ route('Order.index') }}";
</script>
@endif

@if(session('success_saved'))
<script>
    alert("{{ session('success_saved') }}");
    window.location.href = "{{ route('Order.index') }}";
</script>
@endif

<div class="container my-5">
  <div class="row">
    <!-- Left Section: Delivery Details -->
    <div class="col-md-7">
      <div class="card shadow-sm p-3">
        <h4 class="mb-3">Delivery Address</h4>
        <form action="{{ route('Order.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your name" required>
          </div>
          <div class="mb-3">
            <label for="fullemail" class="form-label">Email</label>
            <input type="email" class="form-control" id="fullemail" name="fullemail" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label for="fullcountry" class="form-label">Country</label>
            <input type="text" class="form-control" id="fullcountry" name="fullcountry" placeholder="Enter your country" required>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your full address" required></textarea>
          </div>
          <div class="mb-3">
            <label for="mobile" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
          </div>
          <div class="mb-3">
            <label for="pincode" class="form-label">Pincode</label>
            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter pincode" required>
          </div>
          <button type="submit" class="btn btn-save w-100">
            <i class="fas fa-save me-2"></i> Place Order
          </button>
        </form>
      </div>
    </div>

    <!-- Right Section: Order Summary -->
    <div class="col-md-5">
      <div class="card shadow-sm p-4">
        <h4 class="mb-4">Order Summary</h4>
        <!-- Product List -->
        <div class="order-summary-items mb-3 cart-items-container">
          @php
            $totalPrice = 0;
            $totalQuantity = 0;
          @endphp
          @foreach($cartItems as $item)
            @if($item->product)  <!-- Check if product exists -->
              @if($item->product->images->isNotEmpty())  <!-- Ensure product images exist -->
                <div class="d-flex align-items-center mb-3">
                  <img src="{{ asset('Products/'.$item->product->images->first()->ProductImage) }}" alt="{{ $item->product->ProductName }}" class="order-image me-3" style="width: 50px; height: 50px; object-fit: cover;">
                  <div>
                    <h6 class="mb-1">{{ $item->product->ProductName }}</h6>
                    <p class="text-muted mb-0">₹{{ number_format($item->product->ProductPrice, 2) }}</p>
                    <p class="text-muted mb-0">Quantity: {{ $item->Quantities }}</p> <!-- Correct Quantity reference -->
                  </div>
                </div>
                @php
                  $totalPrice += $item->product->ProductPrice * $item->Quantities;  // Correctly calculate price based on Quantity
                  $totalQuantity += $item->Quantities;  // Add to total quantity
                @endphp
              @else
                <!-- Fallback if images are missing -->
                <div class="d-flex align-items-center mb-3">
                  <img src="{{ asset('default-placeholder.png') }}" alt="No Image Available" class="order-image me-3" style="width: 50px; height: 50px; object-fit: cover;">
                  <div>
                    <h6 class="mb-1">{{ $item->product->ProductName }}</h6>
                    <p class="text-muted mb-0">₹{{ number_format($item->product->ProductPrice, 2) }}</p>
                    <p class="text-muted mb-0">Quantity: {{ $item->Quantities }}</p> <!-- Correct Quantity reference -->
                  </div>
                </div>
                @php
                  $totalPrice += $item->product->ProductPrice * $item->Quantities;  // Correctly calculate price based on Quantity
                  $totalQuantity += $item->Quantities;  // Add to total quantity
                @endphp
              @endif
            @else
              <!-- Fallback if product is missing -->
              <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('default-placeholder.png') }}" alt="No Product Available" class="order-image me-3" style="width: 50px; height: 50px; object-fit: cover;">
                <div>
                  <h6 class="mb-1">Product Unavailable</h6>
                  <p class="text-muted mb-0">₹0.00</p>
                </div>
              </div>
            @endif
          @endforeach
        </div>
        <hr>
        <!-- Pricing Information -->
        <div class="d-flex justify-content-between mb-3">
          <p class="fw-bold">Subtotal</p>
          <p class="fw-bold">₹{{ number_format($totalPrice, 2) }}</p>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <p class="fw-bold">Shipping</p>
          <p class="fw-bold">₹50.00</p>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-4">
          <h5>Total</h5>
          <h5>₹{{ number_format($totalPrice + 50, 2) }}</h5>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-4">
          <p class="fw-bold">Total Items</p>
          <p class="fw-bold">{{ $totalQuantity }}</p> <!-- Display Total Quantity -->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

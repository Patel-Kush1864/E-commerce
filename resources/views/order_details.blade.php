@extends('admin_header')

@section('section')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/order_details.css') }}">
@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

@if(session('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif
<div class="container mt-5">
  <h1 class="mb-4">Order Details</h1>
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="fas fa-box"></i> Order ID: {{ $order->Order_id }}</h5>
    </div>
    <div class="card-body">
      <!-- Customer Info -->
      <h5 class="text-secondary mb-3"><i class="fas fa-user"></i> Customer Information</h5>
      <div class="row mb-4">
        <div class="col-md-6">
          <p><strong>Name:</strong> {{ $order->Fullname }}</p>
          <p><strong>Email:</strong> {{ $order->Email }}</p>
          <p><strong>Mobile:</strong> {{ $order->Mobile_no }}</p>
        </div>
        <div class="col-md-6">
          <p><strong>Address:</strong> {{ $order->Address }}</p>
          <p><strong>Pincode:</strong> {{ $order->Pincode }}</p>
          <p><strong>Country:</strong> {{ $order->Country }}</p>
        </div>
      </div>

      <!-- Order Info -->
      <h5 class="text-secondary mb-3"><i class="fas fa-shopping-cart"></i> Order Summary</h5>
      <div class="row mb-4">
        <div class="col-md-6">
          <p><strong>Total Items:</strong> {{ $order->Total_items }}</p>
          <p><strong>Subtotal:</strong> ₹{{ number_format($order->Subtotal, 2) }}</p>
          <p><strong>Shipping Charges:</strong> ₹{{ number_format($order->Shipping_charges, 2) }}</p>
        </div>
        <div class="col-md-6">
          <p><strong>Total Amount:</strong> <span class="text-success">₹{{ number_format($order->Total_amount, 2) }}</span></p>
          <form action="{{ route('Order.updateStatus', $order->Order_id) }}" method="POST">
            @csrf
            @method('PUT')
            <p><strong>Status:</strong>
              <select name="status" class="status-select form-control d-inline" onchange="this.form.submit()">
                <option value="pending" {{ $order->Status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $order->Status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="delivered" {{ $order->Status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="need_to_pickup" {{ $order->Status == 'need_to_pickup' ? 'selected' : '' }}>Need to Pickup</option>
                <option value="picked_up" {{ $order->Status == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
              </select>
            </p>
          </form>
          <p><strong>Order Date:</strong> {{ date('d M Y, h:i A', strtotime($order->created_at)) }}</p>
        </div>
      </div>

      <!-- Items Info -->
      <h5 class="text-secondary mb-3"><i class="fas fa-list"></i> Items in Order</h5>
      <table class="table table-bordered table-hover">
        <thead class="bg-light">
          <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Item ID</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cartItems as $key => $cartItem)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $cartItem->product ? $cartItem->product->ProductName : 'Product not found' }}</td>
              <td>{{ $cartItem->Prod_id }}</td>
              <td>{{ $cartItem->Quantities }}</td>
              <td>₹{{ number_format($cartItem->Price, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer text-center">
      <a href="{{ route('Order.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Orders</a>
    </div>
  </div>
</div>
@endsection

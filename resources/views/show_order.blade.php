@extends('admin_header')

@section('section')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/show_order.css') }}">

<div class="container mt-5">
  <h1 class="mb-4">Order Management</h1>

  <!-- Search, Filter, and Sort -->
  <div class="row mb-4">
    <div class="col-md-8">
      <form method="GET" action="{{ route('Order.index') }}" class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search orders by name, email, or order ID" value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
      </form>
    </div>
    <div class="col-md-4">
      <form method="GET" action="{{ route('Order.index') }}">
        <div class="row">
          <!-- Filter by Status -->
          <div class="col-md-6">
            <select name="status" class="form-select">
              <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Statuses</option>
              <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>confirmed</option>
              <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>delivered</option>
              <option value="need_to_pickup" {{ request('status') == 'need_to_pickup' ? 'selected' : '' }}>need_to_pickup</option>
              <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>picked_up</option>
            </select>
          </div>
          <!-- Sort by Amount -->
          <div class="col-md-6">
            <select name="sortBy" class="form-select">
              <option value="" {{ request('sortBy') == '' ? 'selected' : '' }}>Sort By</option>
              <option value="amount_asc" {{ request('sortBy') == 'amount_asc' ? 'selected' : '' }}>Amount: Low to High</option>
              <option value="amount_desc" {{ request('sortBy') == 'amount_desc' ? 'selected' : '' }}>Amount: High to Low</option>
              <option value="date_asc" {{ request('sortBy') == 'date_asc' ? 'selected' : '' }}>Date: Oldest First</option>
              <option value="date_desc" {{ request('sortBy') == 'date_desc' ? 'selected' : '' }}>Date: Newest First</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-secondary mt-3 w-100">Apply Filters</button>
      </form>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Orders Overview</h5>
    </div>
    <div class="card-body">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total Items</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          <tr>
            <td>{{ $order->Order_id }}</td>
            <td>{{ $order->Fullname }}</td>
            <td>{{ $order->Email }}</td>
            <td>{{ $order->Total_items }}</td>
            <td>₹{{ number_format($order->Total_amount, 2) }}</td>
            <td>
              <span class="badge 
                @if($order->Status == 'pending') bg-warning 
                @elseif($order->Status == 'confirmed') bg-info 
                @elseif($order->Status == 'delivered') bg-success 
                @elseif($order->Status == 'need_to_pickup') bg-primary 
                @else bg-secondary 
                @endif">
                {{ ucfirst($order->Status) }}
              </span>
            </td>
            <td>
              <a href="{{ route('Order.show', $order->Order_id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $orders->links() }} <!-- Pagination -->
    </div>
  </div>
</div>
@endsection

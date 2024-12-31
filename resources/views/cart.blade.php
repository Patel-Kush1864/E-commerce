@extends('header')

@section('section')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

@if(session('success'))
<script>
    alert("{{ session('success') }}");
    window.location.href = "{{ route('addtocart.show') }}";
</script>
@endif

<div class="container my-5">
  <h3 class="mb-4">Your Shopping Cart</h3>
  @if(!$cartItems)
    <div class="alert alert-info text-center">
      Your cart is empty.
    </div>
    <div class="text-center my-4">
        <a href="{{ route('Register.index') }}" class="btn btn-primary">Start Shopping</a>
    </div>
  @else
  <div class="row">
    <!-- Cart Items Section -->
    <div class="col-lg-8 cart-items-container">
      @foreach ($cartItems as $item)
      <div class="cart-item card mb-3">
        <div class="row no-gutters">
          <div class="col-md-3 text-center">
            @php
                $image = $item->product->images->first();
            @endphp
            <img src="{{ asset($image ? 'Products/'.$image->ProductImage : 'Products/default.jpg') }}" 
                 class="img-fluid product-image" 
                 alt="{{ $item->product->ProductName }}">
          </div>
          <div class="col-md-6">
            <div class="card-body">
              <h5 class="card-title">{{ $item->product->ProductName }}</h5>
              <p class="card-text text-muted">{{ $item->product->Description }}</p>
              <p class="card-text">Price: 
                <span class="item-price" id="item-price-{{ $item->id }}">
                  &#8377;{{ number_format($item->product->ProductPrice, 2) }}
                </span>
              </p>
            </div>
          </div>
          <div class="col-md-3 mt-3 d-flex flex-column justify-content-between align-items-center">
            <div class="quantity-control mb-2">
              <form action="{{ route('cart.update') }}" method="POST" class="d-inline update-cart-form">
                  @csrf
                  <input type="hidden" name="cart_id" value="{{ $item->Cart_id }}">
                  <input type="hidden" name="Prod_id" value="{{ $item->product->Prod_id }}">
                  <input type="hidden" name="quantity" value="{{ $item->Quantities - 1 }}" class="decrease-quantity">
          
                  <button type="submit" class="btn btn-outline-secondary decrease-btn" data-cart-id="{{ $item->id }}" data-price="{{ $item->product->ProductPrice }}">
                      -
                  </button>
              </form>
          
              <input 
                  type="text" 
                  id="qty-{{ $item->id }}" 
                  class="form-control text-center Quantities-input d-inline-block my-2" 
                  value="{{ $item->Quantities }}" 
                  readonly>
          
              <form action="{{ route('cart.update') }}" method="POST" class="d-inline update-cart-form">
                  @csrf
                  <input type="hidden" name="cart_id" value="{{ $item->Cart_id  }}">
                  <input type="hidden" name="Prod_id" value="{{ $item->product->Prod_id }}">
                  <input type="hidden" name="quantity" value="{{ $item->Quantities + 1 }}" class="increase-quantity">
          
                  <button type="submit" class="btn btn-outline-secondary increase-btn" data-cart-id="{{ $item->id }}" data-price="{{ $item->product->ProductPrice }}">
                      +
                  </button>
              </form>
            </div>
            <p class="item-total-price text-primary" id="item-total-price-{{ $item->Cart_id }}">
              &#8377;{{ number_format($item->product->ProductPrice * ($item->Quantities ?: 1), 2) }}
          </p>
            <form action="{{ route('addtocart.remove',$item->product->Prod_id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm mb-3">Remove</button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  
    <!-- Cart Summary Section -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Price Details</h5>
          <hr>
          <div class="d-flex justify-content-between">
            <p>Total Items</p>
            <p id="total-items">{{ $cartItems->sum('Quantities') }}</p>
        </div>
        <div class="d-flex justify-content-between">
            <p>Total Price</p>
            <p id="cart-total">&#8377;{{ number_format($cartItems->sum(function($item) { return $item->product->ProductPrice * ($item->Quantities); }), 2) }}</p>
        </div>
          <hr>
          <form action="{{ route('Cart.delivery') }}" method="POST" >
            @csrf
            <input type="hidden" name="total_items" id="hidden-total-items" value="{{ $cartItems->count() }}">
            <input type="hidden" name="total_amount" id="hidden-total-amount" value="{{ $cartItems->sum(function ($item) { return $item->product->ProductPrice * ($item->quantity ?: 1); }) }}">       
            <button type="submit" class="btn btn-primary btn-block">Proceed to Checkout</button>
          </form>
          {{-- <button class="btn btn-primary btn-block">Proceed to Checkout</button> --}}
        </div>
      </div>
    </div>
  </div>
  
  @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    function increaseQuantity(cartId, price) {
        let qtyInput = document.getElementById(`qty-${cartId}`);
        let totalPriceElement = document.getElementById(`item-total-price-${cartId}`);

        let currentQty = parseInt(qtyInput.value) || 0;
        let newQty = currentQty + 1;

        // Update quantity in the input field
        qtyInput.value = newQty;

        // Update total price for the item
        let itemTotalPrice = newQty * price;
        totalPriceElement.innerHTML = `&#8377;${itemTotalPrice.toFixed(2)}`;

        // Update the total cart price and total items
        updateCartTotal();
    }

    function decreaseQuantity(cartId, price) {
        let qtyInput = document.getElementById(`qty-${cartId}`);
        let totalPriceElement = document.getElementById(`item-total-price-${cartId}`);

        let currentQty = parseInt(qtyInput.value) || 0;
        if (currentQty > 1) {
            let newQty = currentQty - 1;

            // Update quantity in the input field
            qtyInput.value = newQty;

            // Update total price for the item
            let itemTotalPrice = newQty * price;
            totalPriceElement.innerHTML = `&#8377;${itemTotalPrice.toFixed(2)}`;

            // Update the total cart price and total items
            updateCartTotal();
        }
    }

    function updateCartTotal() {
    let total = 0;
    let totalItems = 0;

    document.querySelectorAll(".item-total-price").forEach((element) => {
        // Parse the value, strip '₹' and commas, and add it to total price
        let itemTotal = parseFloat(element.innerHTML.replace('₹', '').replace(',', ''));
        total += itemTotal;
    });

    document.querySelectorAll(".Quantities-input").forEach((input) => {
        // Sum the quantities
        totalItems += parseInt(input.value) || 0;
    });

    // Update the UI with the total values
    document.getElementById("cart-total").innerHTML = `&#8377;${total.toFixed(2)}`;
    document.getElementById("total-items").innerHTML = totalItems;

    // Update the hidden inputs for form submission
    document.getElementById("hidden-total-amount").value = total;
    document.getElementById("hidden-total-items").value = totalItems;
}
    document.querySelectorAll(".increase-btn").forEach((button) => {
        button.addEventListener("click", function () {
            let cartId = this.getAttribute("data-cart-id");
            let price = parseFloat(this.getAttribute("data-price"));
            increaseQuantity(cartId, price);
        });
    });

    document.querySelectorAll(".decrease-btn").forEach((button) => {
        button.addEventListener("click", function () {
            let cartId = this.getAttribute("data-cart-id");
            let price = parseFloat(this.getAttribute("data-price"));
            decreaseQuantity(cartId, price);
        });
    });
});
  
</script>
@endsection

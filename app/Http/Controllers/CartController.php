<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Cartitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function heart(Request $request, string $id)
    {
        
        // Validate client_id in the request
        // $request->validate([
        //     'client_id' => 'required|integer|exists:clients,id', // Ensure the client exists
        // ]);
        
        // Retrieve the client_id from the session
        $clientId = Session::get('client_id');
        
        // Debug the session value
        // return $clientId;

        // Check if the product id is valid
        $prodId = $id;

        // Debug the product ID
        // return $prodId;

        // Check if a cart exists for the client
        $cart = Cart::where('Client_id', $clientId)
                      ->where('Is_wishlist', true)
                      ->first();

        // Debug if the cart exists
        // if ($cart)
        // {
        //     return "true";
        // } 
        // else
        // {
        //     return "false";
        // }

        // If no cart exists, create a new one
        if (!$cart) {
            $cart = Cart::create([
                'Client_id' => $clientId,
                'Is_wishlist' => true,
            ]);
        }
        // Check if the product already exists in the cartitems table
        $cartItem = Cartitem::where('Cart_id', $cart->Cart_id)
                    ->where('Prod_id', $prodId)
                    
                    ->first();
       
        // Debug if the cart item exists
        // if ($cartItem)
        // {
        //     return "true";
        // } 
        // else
        // {
        //     return "false";
        // }

        // If no cart item exists, insert it
        if (!$cartItem) {
            $cartItem = Cartitem::create([
                'Cart_id' => $cart->Cart_id,
                'Prod_id' => $prodId,
                'Quantities' => 1,
                'Price' => 0,
            ]);

            // Redirect with success message
            return redirect()->route('Register.index')->with('success_wishlist', 'Product added to wishlist successfully.');
        }
        else
        {
            // Redirect with success message
            return redirect()->route('Register.index')->with('success_wishlist', 'Product already exist in whislist.');
        }
            

        
    }


    public function addtocart(Request $request, string $id)
    {
        
        // Validate client_id in the request
        // $request->validate([
        //     'client_id' => 'required|integer|exists:clients,id', // Ensure the client exists
        // ]);
        
        // Retrieve the client_id from the session
        $clientId = Session::get('client_id');
        
        // Debug the session value
        // return $clientId;

        // Check if the product id is valid
        $prodId = $id;

        // Check if the product exists in the Product table
        $product = Product::where('Prod_id', $id)->first();
        
        if (!$product) {
            return redirect()->route('Register.index')->with('error', 'Product not found.');
        }
        // return $product->ProductPrice;
        // Debug the product ID
        // return $prodId;

        // Check if a cart exists for the client
        $cart = Cart::where('Client_id', $clientId)
                      ->where('Is_wishlist', false)
                      ->first();

        // Debug if the cart exists
        // if ($cart)
        // {
        //     return "true";
        // } 
        // else
        // {
        //     return "false";
        // }

        // If no cart exists, create a new one
        if (!$cart) {
            $cart = Cart::create([
                'Client_id' => $clientId,
                'Is_wishlist' => false,
            ]);
        }

        // Check if the product already exists in the cartitems table
        $cartItem = Cartitem::where('Cart_id', $cart->Cart_id)
                    ->where('Prod_id', $prodId)
                    ->first();
       
        // Debug if the cart item exists
        // if ($cartItem)
        // {
        //     return "true";
        // } 
        // else
        // {
        //     return "false";
        // }

        // If no cart item exists, insert it
        if (!$cartItem) {
            $cartItem = Cartitem::create([
                'Cart_id' => $cart->Cart_id,
                'Prod_id' => $prodId,
                'Quantities' => 1,
                'Price' => $product->ProductPrice, // Use ProductPrice directly from the fetched model
            ]);

            // Redirect with success message
            return redirect()->route('Register.index')->with('success_wishlist', 'Product added to Add To Cart successfully.');
        }
        else
        {
            // Redirect with success message
            return redirect()->route('Register.index')->with('success_wishlist', 'Product already exist in Add To Cart.');
        }
    }

    public function showWishlist(Request $request)
    {
        // Retrieve the client_id from the session
        $clientId = Session::get('client_id');
        
        // Debug the session value
        if (!$clientId) {
            return redirect()->route('Register.index')->with('error', 'Client not logged in.');
        }

        // Fetch the wishlist cart for the client
        $wishlist = Cart::where('Client_id', $clientId)
            ->where('Is_wishlist', true)
            ->with(['cartItems.product']) // Assuming a relation to products
            ->first();

        // Check if the wishlist exists
        if (!$wishlist) {
            return view('wishlist', ['wishlistItems' => []]);
        }

        // Get the products in the wishlist
        $wishlistItems = $wishlist->cartItems;

        return view('wishlist', compact('wishlistItems'));
    }


    public function showAddToCart(Request $request)
    {
        // Retrieve the client_id from the session
        $clientId = Session::get('client_id');
        
        // Debug the session value
        if (!$clientId) {
            return redirect()->route('Register.index')->with('error', 'Client not logged in.');
        }

        // Fetch the cart for the client where Is_wishlist is false
        $cart = Cart::where('Client_id', $clientId)
            ->where('Is_wishlist', false)
            ->with(['cartItems.product']) // Assuming a relation to products
            ->first();
       
                
        // If no cart exists, return an empty cart view
        if (!$cart) {
            return view('cart', ['cartItems' => []]);
        }

        // Get the products in the cart
        $cartItems = $cart->cartItems;
        // return $cartItems;
        return view('cart', compact('cartItems'));
    }

    public function removeFromWishlist(string $id)
    {
        // Retrieve the client_id from the session
        $clientId = Session::get('client_id');

        if (!$clientId) {
            return redirect()->route('Register.index')->with('error', 'Client not logged in.');
        }

         // Find the cart that is a wishlist for the client
        $cart = Cart::where('Client_id', $clientId)
                    ->where('Is_wishlist', true)
                    ->first();

        if (!$cart) {
            return redirect()->route('wishlist.show')->with('error', 'Wishlist not found.');
        }
    
        // Find the cart item by its ID and Cart_id
        $cartItem = Cartitem::where('Cart_id', $cart->Cart_id)
            ->where('Prod_id', $id)
            ->delete();

        if (!$cartItem) {
            return redirect()->route('wishlist.show')->with('error', 'Wishlist not found.');
        }

        return redirect()->route('wishlist.show')->with('success', 'Product removed from wishlist successfully.');

        // return redirect()->route('wishlist.show')->with('error', 'Product not found in wishlist.');
    }


    public function removeFromAddToCart(string $id)
    {
        // Retrieve the client_id from the session
        $clientId = Session::get('client_id');

        if (!$clientId) {
            return redirect()->route('Register.index')->with('error', 'Client not logged in.');
        }

         // Find the cart that is a wishlist for the client
        $cart = Cart::where('Client_id', $clientId)
                    ->where('Is_wishlist', false)
                    ->first();
        
        if (!$cart) {
            return redirect()->route('addtocart.show')->with('error', 'Add To Cart not found.');
        }
    
        // Find the cart item by its ID and Cart_id
        $cartItem = Cartitem::where('Cart_id', $cart->Cart_id)
            ->where('Prod_id', $id)
            ->delete();

        if (!$cartItem) {
            return redirect()->route('addtocart.show')->with('error', 'Add To Cart not found.');
        }

        return redirect()->route('addtocart.show')->with('success', 'Product removed from Add To Cart successfully.');

        // return redirect()->route('wishlist.show')->with('error', 'Product not found in wishlist.');
    }


    public function update(Request $request)
    {
        $id = $request->cart_id;
        $pid = $request->Prod_id;

        // Use first() to get a single CartItem instance
        $cartItem = CartItem::where('Cart_id', $id)
                            ->where('Prod_id', $pid)
                            ->first(); // Use first() instead of get()

        // return $cartItem;
        // Check if the cartItem is found
        if ($cartItem) {
            $cartItem->Quantities = $request->quantity;
            $cartItem->Price = $cartItem->product->ProductPrice * $request->quantity;
            $cartItem->save();

            $cartItem=Cartitem::where('Cart_id', $id)
                            ->where('Prod_id', $pid)
                            ->get();
           
            return redirect()
            
            
            ->route('addtocart.show');
            // // Return JSON response for AJAX
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Cart updated successfully.',
            //     'cartItem' => [
            //         'cart_id' => $cartItem->Cart_id,
            //         'quantity' => $cartItem->Quantities,
            //         'price' => $cartItem->Price,
            //     ],
            // ]);
        }

        // If no CartItem is found, return failure response
        return response()->json(['success' => false, 'message' => 'Failed to update cart item.']);

    }
    /**
     * Display a listing of the resource.
     */
    public function delivery()
    {
        // Fetch the client_id from session
        $clientId = Session::get('client_id');
    
        // Check if client_id exists in session
        if (!$clientId) {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }
    
        // Fetch the cart items for the current client based on session client_id
        // Assuming that the Cart table has a client_id field that links to the user/client
        $cart = Cart::with('cartItems.product.images')  // Eager load cartItems, product, and product images
                    ->where('client_id', $clientId)
                    ->where('Is_wishlist', false)
                    ->first();
        // return $cart;
        if (!$cart) {
            return redirect()->route('cart.empty')->with('error', 'Your cart is empty.');
        }
    
        // Calculate the subtotal for the cart, ensuring the product exists
        // $subtotal = $cart->cartItems->sum(function ($item) {
        //     if ($item->product) {
        //         return $item->product->ProductPrice * $item->Quantities;
        //     }
        //     return 0; // Skip if no product found
        // });
    
        // Calculate the total number of items in the cart
        // $totalItems = $cart->cartItems->sum('Quantities');
    
        // Return the view with the data
        return view('Order', [
            'cartItems' => $cart->cartItems,
            // 'subtotal' => $subtotal,
            // 'totalItems' => $totalItems
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Cart $cart)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}

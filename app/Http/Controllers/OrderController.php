<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cartitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();
      
        // Apply search filter
        if ($request->search) {
            $fields = ['Fullname', 'Email', 'Order_id'];
            $search = $request->search;
            $query->where(function ($q) use ($fields, $search) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'like', "%$search%");
                }
            });
        }


        // Apply status filter
        if ($request->status) {
            $query->where('Status', $request->status);
        }

        // Apply sorting
        if ($request->sortBy) {
            switch ($request->sortBy) {
                case 'amount_asc':
                    $query->orderBy('Total_amount', 'asc');
                    break;
                case 'amount_desc':
                    $query->orderBy('Total_amount', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $orders = $query->paginate(10);

        return view('show_order', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->route('Order.index')->with('error', 'Order not found!');
        }
        $order->Status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
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
         // Validate the incoming request data
        $request->validate([
            'fullName' => 'required|string|max:255',
            'fullemail' => 'required|email|max:255',
            'fullcountry' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'pincode' => 'required|string|max:10',
        ]);

        // Get the authenticated client
        $clientId = Session::get('client_id');
    
        // Fetch the cart for the client (assumes that each client has one active cart)
        $cart = Cart::where('client_id', $clientId)
                    ->where('Is_wishlist', false)
                    ->first();
        // return $cart;
        $id=$cart->Cart_id;
        // return $id;
        
        // Check if cart exists
        if (!$cart) {
            return redirect()->route('addtocart.show')->with('error', 'No active cart found.');
        }

        // Get the cart items for the client's active cart
        $cartItems = Cartitem::where('Cart_id', $id)->get();
        // return $cartItems;
        
        
        foreach ($cartItems as $cartItem) {
            // Get the product ID from the cart item
            $pid = $cartItem->Prod_id;
            $qty = $cartItem->Quantities;

            // Fetch the product details for this product ID
            $product = Product::where('Prod_id', $pid)->first();

            // Check if the product exists and has enough stock
            if ($product) {
                if ($product->ProductStock >= $qty) {
                    // Update the ProductStock by subtracting the quantity from the cart item
                    $product->ProductStock -= $qty;
                    $product->save();  // Save the updated product record
                } else {
                    // If there's not enough stock, you can return an error message or handle the case accordingly
                    return redirect()->route('addtocart.show')->with('error', "Not enough stock for product: " . $product->ProductName);
                }
            }
        }


        // Calculate the total items and subtotal from the cart items
        $totalItems = $cartItems->sum('Quantities'); // Case-sensitive
        // return $totalItems;
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->ProductPrice * $item->Quantities;
        });

        // Define the shipping charges (fixed or calculated based on logic)
        $shippingCharges = 50;

        // Calculate the total amount
        $totalAmount = $subtotal + $shippingCharges;

        // Create the order record
        $order = Order::create([
            'client_id' => $clientId,
            'cartitems_id' => json_encode($cartItems->pluck('id')->toArray()), // Serialize array
            'Fullname' => $request->input('fullName'),
            'Email' => $request->input('fullemail'),
            'Country' => $request->input('fullcountry'),
            'Address' => $request->input('address'),
            'Mobile_no' => $request->input('mobile'),
            'Pincode' => $request->input('pincode'),
            'Total_items' => $totalItems,
            'Subtotal' => $subtotal,
            'Shipping_charges' => $shippingCharges,
            'Total_amount' => $totalAmount,
            'Status' => 'pending',
        ]);

        // Optionally, you can clear the cart items after placing the order
        // Cartitem::where('cart_id', $cart->id)->delete();

        // Return a response or redirect
        return redirect()->route('Register.index')->with('success', 'Order placed successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show($Order_id)
    {
        // Fetch the order details from the database
        $order = Order::findOrFail($Order_id);
    
        // Decode the cartitems_id array from the order
        $cartItemsIds = json_decode($order->cartitems_id);
    
        // Retrieve the cart items associated with the order
        $cartItems = Cartitem::whereIn('id', $cartItemsIds)->get();
    
        // Initialize variables to store total quantity and total price
        $totalQuantity = 0;
        $totalPrice = 0;
    
        // Loop through the cart items to calculate total quantity and price
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product; // Assuming the relationship is set up between Cartitem and Product
    
            // Calculate the quantity and price for each item in the cart
            $quantity = $cartItem->Quantities;
            $price = $product->ProductPrice;
    
            // Add to total quantity and total price
            $totalQuantity += $quantity;
            $totalPrice += $quantity * $price;
        }
    
        // Pass the order details and totals to the view
        return view('order_details', compact('order', 'totalQuantity', 'totalPrice', 'cartItems'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

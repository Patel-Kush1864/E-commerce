<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Register;
use Illuminate\Support\Facades\Session; // Use Session facade
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function showRegisterForm(Request $request)
    {
        return view("register");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Session::has('client_id')) {
            // dd('Client is not logged in'); // Debug message
             return redirect('/login')->with('error', 'You must be logged in to view products.');
         }
 
         // Fetch all products with category details
         $products = Product::with(['category', 'images'])->where('status', 'Active')->paginate(12);

         // Return view with products
         return view('show_product', compact('products'));
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
    public function store(RegisterRequest $request)
    {
        try {
            // Attempt to insert the data
            Register::create([
                "name"=> $request->Name,
                "email"=> $request->Email,
                "gender"=> $request->Gender,
                "password"=> $request->Password,
            ]);

            // If successful, redirect with a success message
            return redirect()->route("Register.showRegisterForm")
                        ->with("success","Your Details Successfully Inserted..");
        } catch (\Exception $e) {
            // If insertion fails, redirect back with an error message
            return redirect()->route("Register.showRegisterForm")
                            ->with("error","Failed to insert details. Please try again.");
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register)
    {
        //
    }
}

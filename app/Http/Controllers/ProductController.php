<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
// use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'images'])->paginate(12);

    //   return $products;
        return view('admin_showproduct', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view("add_product",compact("categories"));
    }

    public function store(ProductRequest $request)
    {
        // return "HELLO";

        // Handle file upload (multiple files)
        $imagenames = [];
        if ($request->hasFile('ProductImage')) {
            foreach ($request->file('ProductImage') as $file) {
                // Ensure the file is an instance of UploadedFile
                if ($file->isValid()) {
                    $imagename = time() . '-' . uniqid() . '.' . $file->extension();
                    $file->move(public_path('Products'), $imagename);
                    $imagenames[] = $imagename; // Store the image name
                }
            }
        }
        
        $product=Product::create([
            "category_id"=> $request->category_id,
            "productname"=> $request->ProductName,
            "productprice"=> $request->ProductPrice,
            "brand"=> $request->Brand,
            "modelnumber"=> $request->ModelNumber,
            "warrantyperiod"=> $request->WarrantyPeriod,
            "status"=> $request->Status,
            "productstock"=> $request->ProductStock,
            "description"=> $request->Description,
        ]);

        // return $product;        
        // Insert image data into the ProductImages table with the product ID
        foreach ($imagenames as $imagename) {
            ProductImage::create([
                "product_id" => $product->id, // Associate with the product
                "productimage" => $imagename, // Store image name as string
            ]);
        }
       
        // return $data;
        return redirect()->route("Product.create")
                         ->with("success","Your Product Details Successfully Inserted..");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product,String $id)
    {
        // Fetch the product with its related category and images
        $product = Product::with(['category', 'images'])->find($id);
        if (!$product) {
            return redirect()->route("Register.index")
                         ->with("success","Product not found!");
           
        }
        return view('product_details', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}

@extends('admin_header')
@section('section')

<link rel="stylesheet" href="{{ asset('css/add_product.css') }}">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card admin-form-card">
                <div class="card-header text-center">
                    Add Product
                </div>

                <div class="card-body">
                    <!-- Success/Error Message Display -->
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('Product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Row 1: Category and Product Name -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category">Category</label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->categoryname }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('category_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="productName">Product Name</label>
                                <input type="text" name="ProductName" id="productName" class="form-control" placeholder="Enter Product Name">
                                <span class="text-danger">
                                    @error('ProductName')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Row 2: Product Price and Brand -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productPrice">Price</label>
                                <input type="number" name="ProductPrice" id="productPrice" class="form-control" placeholder="Enter Product Price" step="0.01">
                                <span class="text-danger">
                                    @error('ProductPrice')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="productBrand">Brand</label>
                                <input type="text" name="Brand" id="productBrand" class="form-control" placeholder="Enter Product Brand">
                                <span class="text-danger">
                                    @error('Brand')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Row 3: Warranty Period and Image -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="modelNumber">Model Number</label>
                                <input type="text" name="ModelNumber" id="modelNumber" class="form-control" placeholder="Enter Model Number">
                                <span class="text-danger">
                                    @error('ModelNumber')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="warrantyPeriod">Warranty Period</label>
                                <select name="WarrantyPeriod" id="warrantyPeriod" class="form-control">
                                    <option value="" selected hidden>Select Warranty Period</option>
                                    <option value="6 Months">6 Months</option>
                                    <option value="1 Year">1 Year</option>
                                    <option value="2 Years">2 Years</option>
                                    <option value="3 Years">3 Years</option>
                                    <option value="5 Years">5 Years</option>
                                </select>
                                <span class="text-danger">
                                    @error('WarrantyPeriod')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            
                        </div>

                        <!-- Row 4: Product Status and Description -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productStock">Product Stock</label>
                                <input type="number" name="ProductStock" id="productStock" class="form-control" placeholder="Enter Product Stock" min="0">
                                <span class="text-danger">
                                    @error('ProductStock')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="status" >Status</label>
                                <div class="switch">
                                    <div class="switch__1">
                                        <input id="statusSwitch" type="checkbox" name="Status" value="Active" {{ old('Status') == 'Active' ? 'checked' : '' }}>
                                        <label for="statusSwitch"></label>
                                    </div>
                                    <span id="statusLabel" style="color: black;">{{ old('Status') == 'Active' ? 'Active' : 'Inactive' }}</span>
                                </div>
                                <span class="text-danger">
                                    @error('Status')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            {{-- <div class="col-md-6 d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="switch">
                                        <div class="switch__1">
                                            <input id="statusSwitch" type="checkbox" name="Status" value="Active" {{ old('Status') == 'Active' ? 'checked' : '' }}>
                                            <label for="statusSwitch"></label>
                                        </div>
                                    </div>
                                    <span id="statusLabel" class="ms-2 fw-bold">Status</span>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="productImage">Image</label>
                                <input type="file" name="ProductImage[]" id="productImage" class="form-control" multiple>
                                <span class="text-danger">
                                    @error('ProductImage')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- Row 5: Product Description -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="productDescription">Description</label>
                                <textarea name="Description" id="productDescription" rows="4" class="form-control" placeholder="Enter product description"></textarea>
                                <span class="text-danger">
                                    @error('Description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success me-2">Add Product</button>
                            <a href="{{ route('Product.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSwitch = document.getElementById('statusSwitch');
        const statusLabel = document.getElementById('statusLabel');

        statusSwitch.addEventListener('change', function () {
            if (statusSwitch.checked) {
                statusSwitch.value = 'Active';
                statusLabel.textContent = 'Active';
            } else {
                statusSwitch.value = 'Inactive';
                statusLabel.textContent = 'Inactive';
            }
        });
    });
</script>

@endsection

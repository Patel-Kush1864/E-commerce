@extends('admin_header')
@section('section')

<link rel="stylesheet" href="{{ asset('css/add_category.css') }}">


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card admin-form-card">
                <div class="card-header text-center">
                    Add Category
                </div>

                <div class="card-body">
                    <!-- Success/Error Message Display -->
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('Category.store') }}" method="POST">
                        @csrf

                        <!-- Category Name Input -->
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" name="CategoryName" id="categoryName" class="form-control" placeholder="Enter category name">
                            <span class="text-danger">
                                @error('CategoryName')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- Buttons -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success me-2">Add Category</button>
                            <a href="{{ route('Category.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

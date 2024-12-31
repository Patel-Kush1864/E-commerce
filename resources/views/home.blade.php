@extends('header')
@section('section')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<!-- Hero Section -->
<div class="hero-section">
    <div>
        <h1>Welcome to TechWorld</h1>
        <p>Leading the way in innovative electronic solutions</p>
        <a href="#services" class="btn btn-light btn-lg">Explore Our Services</a>
    </div>
</div>

<!-- Services Section -->
<section id="services" class="container my-5">
    <h2 class="text-center mb-4">Our Services</h2>
    <div class="row">
        <!-- Service 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/500x300?text=Service+1" class="card-img-top" alt="Service 1">
                <div class="card-body">
                    <h5 class="card-title">Smartphone Repair</h5>
                    <p class="card-text">We offer professional repair services for smartphones, including screen replacements and battery fixes.</p>
                </div>
            </div>
        </div>
        <!-- Service 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/500x300?text=Service+2" class="card-img-top" alt="Service 2">
                <div class="card-body">
                    <h5 class="card-title">Laptop Support</h5>
                    <p class="card-text">Our experts can help with laptop repairs, upgrades, and maintenance to keep your devices running smoothly.</p>
                </div>
            </div>
        </div>
        <!-- Service 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/500x300?text=Service+3" class="card-img-top" alt="Service 3">
                <div class="card-body">
                    <h5 class="card-title">Gadget Installation</h5>
                    <p class="card-text">We provide professional installation for your new gadgets, including smart home devices and audio systems.</p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
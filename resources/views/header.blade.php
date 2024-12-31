<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Example</title>
     <!-- Bootstrap 5 CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Font Awesome Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>
    @if(!isset($hideHeader) || !$hideHeader)
        <!-- Navbar Header -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand" href="#">TechWorld</a>
                <!-- Toggle Button for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Register.index') }}">Show Product</a>
                        </li>
                        {{-- <!-- Order Option -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Order.index_user') }}">Orders</a>
                        </li> --}}
                    </ul>
                    <!-- Search Bar -->
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-success btn-search" type="submit">Search</button>
                    </form>
                    <!-- Icons -->
                    <div class="d-flex ms-3">
                        <a href="{{ route('wishlist.show') }}"><i class="fa fa-heart fa-icon"></i></a>
                        <a href="{{ route('addtocart.show') }}"><i class="fa fa-shopping-cart fa-icon"></i></a>
                    </div>
                </div>
            </div>
        </nav>
        
    @endif

    <!-- Page Content -->
    <div>
        @yield('section')
    </div>
    
    <!-- Footer -->
    <footer class="footer bg-dark text-center text-white py-4">
        <div class="container">
            <p>&copy; 2024 TechWorld. All Rights Reserved.</p>
            <div class="social-icons">
                <a href="#" class="text-white mx-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

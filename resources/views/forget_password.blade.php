@extends('header')
@section('section')
<link rel="stylesheet" href="{{ asset('css/forget_password.css') }}">
 <div class="box mx-auto d-block mt-5">
        <span class="borderLine"></span>
        @if(session('success_pwd'))
        <script>
            alert("{{ session('success_pwd') }}");
            window.location.href = '/login';
        </script>
        @elseif(session('error'))
            <script>
                alert("{{ session('error') }}");
            </script>
        @endif
        <form action="{{ route('forget_pwd') }}" method="POST" onsubmit="return validatePasswords()">
            @csrf
            <h2>Forget Password</h2>
            <div class="inputBox">
                <input type="email" name="Email" id="email" required>
                <span>Email</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="Password" id="password" required>
                <span>Password</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="password_confirm" id="password_confirm" required>
                <span>Confirm Password</span>
                <i></i>
            </div>
            <div class="links">
                <a href="{{ route('forget_password') }}">Forgot Password</a>
                <a href="{{ route('Register.showRegisterForm') }}">Signup</a>
            </div>
            <input type="submit" id="submit" value="Update Password">
        </form>
        
        <script>
            function validatePasswords() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirm').value;
        
                if (password !== confirmPassword) {
                    alert("Passwords do not match. Please try again.");
                    return false; // Prevent form submission
                }
        
                return true; // Allow form submission
            }
        </script>
    </div>
    {{-- for footer --}}
    <div style="padding : 2%;"></div>
@endsection
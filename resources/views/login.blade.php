
@extends('header')
@section('section')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
 <div class="box mx-auto d-block mt-5">
        <span class="borderLine"></span>
        @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        
            @if(session('success') == 'Admin login successful!')
                window.location.href = "/admin_dashboard";
            @else
                window.location.href = "{{ route('Register.index') }}";
            @endif
        </script>
        @elseif(session('success_logout'))
        <script>
            alert("{{ session('success_logout') }}");
            window.location.href = '/login';
        </script>
        @endif
        @if(session('success_pwd'))
        <script>
            alert("{{ session('success_pwd') }}");
            window.location.href = '/login';
        </script>
        @endif
        @if(session('error'))
            <script>
                alert("{{ session('error') }}");
            </script>
        @endif
        <form action="{{route('login_user') }}" method="POST">
            @csrf
            <h2>Login</h2>
            <div class="inputBox">
                <input type="text" name="Name" required>
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="Password" required>
                <span>Password</span>
                <i></i>
            </div>
            <div class="links">
                <a href="{{ route('forget_password') }}">Forgot Password</a>
                <a href="{{route('Register.showRegisterForm') }}">Signup</a>
            </div>
            <input type="submit" id="submit" value="Login">
        </form>
    </div>
    {{-- for footer --}}
    <div style="padding : 2%;"></div>
@endsection
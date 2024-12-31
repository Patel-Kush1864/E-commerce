@extends('header')
@section('section')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");

        @if(session('success') == 'Your Details Successfully Inserted..')
            window.location.href = "/login";
        @endif
    </script>
    @endif

    @if(session('success_addcart'))
    <script>
        alert("{{ session('success_addcart') }}");
        window.location.href = "{{ route('Register.index') }}";
    </script>
    @endif

    @if(session('error'))
    <script>
        alert("{{ session('error') }}");
        redirectToLogin();
    </script>
    @endif

 <div class="box mx-auto d-block mt-5">
        <span class="borderLine"></span>
        <form action="{{ route('Register.store') }}" method="POST">
            @csrf
            <h2>Sign up</h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="inputBox">
                        <input type="text" name="Name" class="@error('Name') is-invalid  @enderror" required>
                        <span>Username</span>
                        <i></i>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="Gender" class="@error('Gender') is-invalid  @enderror" required>
                        <span>Gender</span>
                        <i></i>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="inputBox">
                        <input type="email" name="Email" class="@error('Email') is-invalid  @enderror" required>
                        <span>mail</span>
                        <i></i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="Password" class="@error('Password') is-invalid  @enderror" required>
                        <span>Password</span>
                        <i></i>
                    </div>
                </div>
            </div>
            <input type="submit" id="submit" value="Register" class="mt-5">
        </form>
    
       
       
    </div>
    {{-- for footer --}}
    <div style="padding : 2%;"></div>
@endsection
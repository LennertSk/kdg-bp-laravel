@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper step-1'>
    

    <form method='POST' class='form' action='{{ url("dashboard/login") }}'>
    <h1>Welcome back. Please login to access your survey dashboard.</h1> 
        @csrf

        <label for="code" class='form__label'>Survey code</label>
        <input id="code" name='code' type="text" class="form__input--text @error('code') is-invalid @enderror">
        @error('code')
            <div class='form__error'>{{ $message }}</div>
        @enderror

        <label for="password" class='form__label'>Password</label>
        <input id="password" name='password' type="password" class="form__input--password @error('password') is-invalid @enderror">
        <div class='form__input--show'>
            <input id='togglePass' type="checkbox"  name='togglePass' onclick="showPassword()">
            <label for="togglePass" class='form__label'>Show password.</label>   
        </div>
        @error('password')
            <div class='form__error'>{{ $message }}</div>
        @enderror

        <button class='form__submit' type='submit'>
            Continue
        </button>

    </form>
    </div>
</div>
@endsection


<script>
    function showPassword() {
        var field = document.getElementById("password");
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    }
</script>

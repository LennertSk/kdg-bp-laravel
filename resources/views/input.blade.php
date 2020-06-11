@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper step-1'> 

    <form method='POST' class='form' action='{{ url("get-started/set") }}'>
    <h1>Let's get started.</h1>
        @csrf

        <label for="title" class='form__label'>First off, we need to give it a name</label>
        <input id="title" name='title' type="text" class="form__input--text @error('title') is-invalid @enderror">
        @error('title')
            <div class='form__error'>{{ $message }}</div>
        @enderror

        <label for="code" class='form__label'>People will find you by entering the following code so make sure it's clear and simple to remember</label>
        <input id="code" name='userCode' type="text" class="form__input--text @error('code') is-invalid @enderror" onchange='getCodeOutput()'>
        <p class='form__subtext'>Your code will be: <span id='code-output'>...</span></p>
        <input type='text' id='code-input' name='code' hidden>
        @error('code')
            <div class='form__error'>{{ $message }}</div>
        @enderror

        <label for="description" class='form__label'>Add a description</label>
        <textarea id="description" name='description' type="text" class="form__input--textarea @error('description') is-invalid @enderror"></textarea>
        @error('description')
            <div class='form__error'>{{ $message }}</div>
        @enderror

        <label for="username" class='form__label'>What should we call you?</label>
        <input id="username" name='username' type="text" class="form__input--text @error('username') is-invalid @enderror">
        @error('username')
            <div class='form__error'>{{ $message }}</div>
        @enderror

        <label for="password" class='form__label'>Secure your survey with a password so you can add questions or check up on user feedback later on.</label>
        <input id="password" name='password' type="password" class="form__input--password @error('password') is-invalid @enderror">
        <div class='form__input--show'>
            <input type="checkbox"  name='togglePass' onclick="showPassword()">
            <label id='togglePass' for="togglePass" class='form__label'>Show password.</label>   
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
    function getCodeOutput() {
        var str = document.getElementById("code").value
        str = str.replace(/\s+/g, '-').toLowerCase()
        document.getElementById('code-output').textContent = str
        document.getElementById('code-input').value = str
    }

    function showPassword() {
        var field = document.getElementById("password");
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    }
</script>


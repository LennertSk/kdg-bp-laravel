@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper step-1'>
        <div class='svg svg-top'>
            <img src='{{ URL::to("/images/svg-question-1.svg") }}' alt='Question Svg'>
        </div>
        <form method='POST' class='form' action='{{ url("add-question/question") }}'>
            @csrf

            <label for="question" class='form__label'>What would you like to ask?</label>
            <input id="question" name='question' type="text" class="form__input--text @error('question') is-invalid @enderror">
            @error('question')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <label for="url" class='form__label'>Summarize your question in 1 to 3 words. This will be used as a url so keep it short and simple.</label>
            <input id="url" name='userUrl' type="text" class="form__input--text @error('url') is-invalid @enderror" onchange='getUrlOutput()'>
            <p class='form__subtext'>This question url will be: <span id='url-output'>...</span></p>
            <input type='text' id='url-input' name='url' hidden>
            @error('url')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <button class='form__submit' type='submit'>
                Continue
            </button>
        </form>
        <div class='svg svg-bottom'>
            <img src='{{ URL::to("/images/svg-question-1.svg") }}' alt='Question Svg'>
        </div>
    </div>
</div>
@endsection


<script>
    function getUrlOutput() {
        var str = document.getElementById("url").value
        str = str.replace(/\s+/g, '-').toLowerCase()
        document.getElementById('url-output').textContent = str
        document.getElementById('url-input').value = str
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
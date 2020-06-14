@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper step-1'>
        <form method='POST' class='form' action='{{ url("/add-question/info/set") }}'>
            @csrf

            <label for="answer" class='form__label'>You can give the users some more info after they answer correctly.</label>
            <input id="answer" name='answer' type="text" class="form__input--text @error('answer') is-invalid @enderror">
            @error('answer')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <label for="tip" class='form__label'>Adding unlockable tips can help give the user more information about your subject. (optional)</label>
            <input id="tip" name='tip' type="text" class="form__input--text @error('tip') is-invalid @enderror">
            @error('tip')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <button class='form__submit' type='submit'>
                Continue
            </button>
        </form>
        <div class='svg svg-bottom'>
            <img src='{{ URL::to("/images/svg-question-2.svg") }}' alt='Info Svg'>
        </div>
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
</script>


@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper step-1'>
        <form method='POST' class='form' action='{{ url("/add-question/post/select") }}'>
        <h1>Add the possible options.</h1> 
            @csrf

            <div class='checkbox'>
                <input id='openQuestion' type="checkbox"  name='openQuestion' onclick="toggleAnswer()">
                <label for="openQuestion" class='form__label'>This is an open-ended question.</label>               
            </div>

            <div id='wrong-answer'>
                <label for="answerWrong" class='form__label toggle-answer'>You can give an explanation when a user selects the wrong answer.</label>
                <input id="answerWrong" name='answerWrong' type="text" class="form__input--text @error('answerWrong') is-invalid @enderror toggle-answer">
            </div>
            @error('answerWrong')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <label for="quantity"class='form__label'>Amount of options (between 2 and 3).</label>
            <input type="number" id="quantity" value='2' name="quantity" min="2" max="3" class="form__input--text" onchange='showOptions()'>

            <div id='option-A'>
                <label for="optionA" class='form__label toggle-answer'>Option 1.</label>
                <input id="optionA" name='optionA' type="text" class="form__input--text @error('optionA') is-invalid @enderror">
            </div>
            @error('optionA')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-B'>
                <label for="optionB" class='form__label toggle-answer'>Option 2.</label>
                <input id="optionB" name='optionB' type="text" class="form__input--text @error('optionB') is-invalid @enderror">
            </div>
            @error('optionB')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-C'>
                <label for="optionC" class='form__label toggle-answer'>Option 3.</label>
                <input id="optionC" name='optionC' type="text" class="form__input--text @error('optionC') is-invalid @enderror">
            </div>
            @error('optionC')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='correct-answer'>
                <label for="correct"class='form__label'>What's the correct option?</label>
                <input type="number" id="correct" name="correct" min="1" max="2" class="form__input--text @error('correct') is-invalid @enderror">                    
            </div>
            @error('correct')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <input type='text' name='type' id="type" value='SelectOptions' hidden>

            <button class='form__submit' type='submit'>
                Continue
            </button>

        </form>
        <div class='svg svg-bottom'>
             <img src='{{ URL::to("/images/svg-question-3.svg") }}' alt='Info Svg'>
         </div>
        </div>
    </div>
</div>
@endsection


<script>
    function toggleAnswer() {
        var fields = document.getElementById('wrong-answer')
        var answer = document.getElementById('correct-answer')
        if (fields.style.display === 'none') {
            fields.style.display = 'block'
            answer.style.display = 'block'
        } else {
            fields.style.display = 'none'
            answer.style.display = 'none'
        }            
    }
    function showOptions() {
        var amount = document.getElementById('quantity').value
        var option3 = document.getElementById('option-C')
        var answer = document.getElementById('correct')
        if (amount == 3) {
            option3.style.display = 'block'
            answer.max = '3'
        } else {
            option3.style.display = 'none'
            answer.max = '2'
        }

    }
</script>

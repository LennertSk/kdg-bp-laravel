@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper step-1'>
        <form method='POST' class='form' action='{{ url("/add-question/post/range") }}'>
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

            <label for="quantity"class='form__label'>Amount of options (between 3 and 10).</label>
            <input type="number" id="quantity" value='3' name="quantity" min="3" max="10" class="form__input--text" onchange='showOptions()'>

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

            <div id='option-C' class='toggle-viz'>
                <label for="optionC" class='form__label toggle-answer'>Option 3.</label>
                <input id="optionC" name='optionC' type="text" class="form__input--text @error('optionC') is-invalid @enderror">
            </div>
            @error('optionC')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-D' class='toggle-viz'>
                <label for="optionD" class='form__label toggle-answer'>Option 4.</label>
                <input id="optionD" name='optionD' type="text" class="form__input--text @error('optionD') is-invalid @enderror">
            </div>
            @error('optionD')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-E' class='toggle-viz'>
                <label for="optionE" class='form__label toggle-answer'>Option 5.</label>
                <input id="optionE" name='optionE' type="text" class="form__input--text @error('optionE') is-invalid @enderror">
            </div>
            @error('optionE')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-F' class='toggle-viz'>
                <label for="optionF" class='form__label toggle-answer'>Option 6.</label>
                <input id="optionF" name='optionF' type="text" class="form__input--text @error('optionF') is-invalid @enderror">
            </div>
            @error('optionF')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-G' class='toggle-viz'>
                <label for="optionG" class='form__label toggle-answer'>Option 7.</label>
                <input id="optionG" name='optionG' type="text" class="form__input--text @error('optionG') is-invalid @enderror">
            </div>
            @error('optionG')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-H' class='toggle-viz'>
                <label for="optionH" class='form__label toggle-answer'>Option 8.</label>
                <input id="optionH" name='optionH' type="text" class="form__input--text @error('optionH') is-invalid @enderror">
            </div>
            @error('optionH')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-I' class='toggle-viz'>
                <label for="optionI" class='form__label toggle-answer'>Option 9.</label>
                <input id="optionI" name='optionI' type="text" class="form__input--text @error('optionI') is-invalid @enderror">
            </div>
            @error('optionI')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='option-J' class='toggle-viz'>
                <label for="optionJ" class='form__label toggle-answer'>Option 10.</label>
                <input id="optionJ" name='optionJ' type="text" class="form__input--text @error('optionJ') is-invalid @enderror">
            </div>
            @error('optionJ')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <div id='correct-answer'>
                <label for="correct"class='form__label'>What's the correct option?</label>
                <input type="number" id="correct" name="correct" min="1" max="2" class="form__input--text @error('correct') is-invalid @enderror">                    
            </div>
            @error('correct')
                <div class='form__error'>{{ $message }}</div>
            @enderror

            <input type='text' name='type' id="type" value='RangeSliderLine' hidden>

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
        var option4 = document.getElementById('option-D')
        var option5 = document.getElementById('option-E')
        var option6 = document.getElementById('option-F')
        var option7 = document.getElementById('option-G')
        var option8 = document.getElementById('option-H')
        var option9 = document.getElementById('option-I')
        var option10 = document.getElementById('option-J')
        var answer = document.getElementById('correct')
        if (amount == 3) {
            option3.style.display = 'block'
            option4.style.display = 'none'
            option5.style.display = 'none'
            option6.style.display = 'none'
            option7.style.display = 'none'
            option8.style.display = 'none'
            option9.style.display = 'none'
            option10.style.display = 'none'
            answer.max = '3'
        } else if (amount == 4) {
            option3.style.display = 'block'
            option4.style.display = 'block'
            option5.style.display = 'none'
            option6.style.display = 'none'
            option7.style.display = 'none'
            option8.style.display = 'none'
            option9.style.display = 'none'
            option10.style.display = 'none'
            answer.max = '4'
        } else if (amount == 5) {
            option3.style.display = 'block'
            option4.style.display = 'block'
            option5.style.display = 'block'
            option6.style.display = 'none'
            option7.style.display = 'none'
            option8.style.display = 'none'
            option9.style.display = 'none'
            option10.style.display = 'none'
            answer.max = '5'
        } else if (amount == 6) {
            option3.style.display = 'block'
            option4.style.display = 'block'
            option5.style.display = 'block'
            option6.style.display = 'block'
            option7.style.display = 'none'
            option8.style.display = 'none'
            option9.style.display = 'none'
            option10.style.display = 'none'
            answer.max = '6'
        } else if (amount == 7) {
            option3.style.display = 'block'
            option4.style.display = 'block'
            option5.style.display = 'block'
            option6.style.display = 'block'
            option7.style.display = 'block'
            option8.style.display = 'none'
            option9.style.display = 'none'
            option10.style.display = 'none'
            answer.max = '7'
        } else if (amount == 8) {
            option3.style.display = 'block'
            option4.style.display = 'block'
            option5.style.display = 'block'
            option6.style.display = 'block'
            option7.style.display = 'block'
            option8.style.display = 'block'
            option9.style.display = 'none'
            option10.style.display = 'none'
            answer.max = '8'
        } else if (amount == 9) {
            option3.style.display = 'block'
            option4.style.display = 'block'
            option5.style.display = 'block'
            option6.style.display = 'block'
            option7.style.display = 'block'
            option8.style.display = 'block'
            option9.style.display = 'block'
            option10.style.display = 'none'
            answer.max = '9'
        } else if (amount == 10) {
            option3.style.display = 'block'
            option4.style.display = 'block'
            option5.style.display = 'block'
            option6.style.display = 'block'
            option7.style.display = 'block'
            option8.style.display = 'block'
            option9.style.display = 'block'
            option10.style.display = 'block'
            answer.max = '10'
        }
    }
</script>

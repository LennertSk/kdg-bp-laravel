@extends('layouts.app')

@section('content')

<div class="container">
    <div class='dashboard-header'>
        <h1 class='title'>{{ $survey['survey_name'] }}</h1>
        <div class='code'>
           <p>{{ $survey['survey_code'] }}</p> 
        </div>
    </div>
    <div class='wrapper dashboard-questions'>
        <p class='dashboard-questions__title'>{{ count($questions) }}/10 questions</p>
        <ul class='questions'>
            @foreach($questions as $question)
            <li class='question'>
                <a href='/get-question/{{ $question["url"] }}' class='question__card'>
                    {{$question['question']}}
                </a>
            </li>
            @endforeach
            @if (count($questions) <= 10) 
            <li class='question question--add'>
                <a href='/add-question' class='question__url'>
                    Add a question.
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>
@endsection

<script>

</script>

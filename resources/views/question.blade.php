@extends('layouts.app')

@section('content')

<div class="container container-question">
    <div class='wrapper wrapper-question'>
        <div class='question-card'>
            <h2 class='question'>
                {{$question['question']}}
            </h2>
            <ul class='options'>
                @foreach ($options as $option)
                <li class='option'>
                    <p class='option__number'>{{ $option['option_answered'] }}</p>
                    <p class='option__text'>{{ $option['option'] }}</p>
                </li>
                @endforeach
            </ul>
            <div class='btn-group'>
                <a href='{{ url("/dashboard") }}' class='btn-group__back'>Back to overview</a>
                <a href='{{ url("/remove-question/" . $question["question_id"]) }}' class='btn-group__rem'>Remove Question</a>
            </div>            
        </div>
    </div>
</div>
@endsection

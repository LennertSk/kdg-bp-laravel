@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper step-2'>
        <h1>Choose the type of answer.</h1> 
        <div class='options'>
            <a href='/add-question/select' class='option'>
                <img class='option__icon'  src='{{ URL::to("/images/svg-select.svg") }}' alt='Select'>
                <div class='option__text'>
                    The user has multiple options to choose from.
                </div>
            </a>
            <a href='/add-question/range' class='option'>
            <img class='option__icon'  src='{{ URL::to("/images/svg-range.svg") }}' alt='Select'>
                <div class='option__text'>
                    The user can use a slider to select the correct option.
                </div>
            </a>
        </div>
    </div>
</div>
@endsection



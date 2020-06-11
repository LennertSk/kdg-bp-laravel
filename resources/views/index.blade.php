@extends('layouts.app')

@section('content')

<div class="container">
    <div class='wrapper wrapper-hero'>
        <div class='hero-text'>
            <h1 class='hero-text__title'>
                Create <span>interactive</span> & <span>easy to use</span> surveys on the go.
            </h1>
            <p class='hero-text__subtitle'>
                Squery is a simple to use survey builder. Build, create and share your personalized questions with the world.
            </p>
            <div class='hero-text__cta'>
                <a href='{{ url("/get-started") }}'>Start Creating Now</a>
                <p >
                *It's 100% free.
                </p>  
            </div>
        </div>
        <div class='hero-svg'>
            <img src='images/svg-hero.svg' alt='Hero Image'>
        </div>
    </div>
    <div class='wrapper-howto'>
        <ul class='howto'>
            <li class='howto__item'>
                <div class='item'>
                    <p class='item__title'>
                        So, how does it work?
                    </p>
                    <p class='subtitle'>
                        Write down some questions you would like to aks and get creating!
                    </p>
                </div>
            </li>
            <li class='howto__item'>
                <div class='item'>
                    <p class='item__nbr'>
                        01
                    </p>
                    <p class='item__title'>
                        Create a survey
                    </p>
                </div>
            </li>
            <li class='howto__item'>
                <div class='item item-standout'>
                    <p class='item__nbr'>
                        02
                    </p>
                    <p class='item__title'>
                    Add Questions & <br> Answers
                    </p>
                    <span class='divider'></span>
                    <p class='item__subtitle'>
                    You can pick whatever question you like and make it your own.
                    </p>
                </div>
            </li>
            <li class='howto__item'>
                <div class='item'>
                    <p class='item__nbr'>
                        03
                    </p>
                    <p class='item__title'>
                    Share with friends
                    </p>
                </div>
            </li>
        </ul>
    </div>
    <div class='wrapper-questions'>
        <p class='questions-title'>Available Options</p>
        <ul class='questions'>
            <li class='questions__item'>
                <div class='questions__item__image'>
                    <img src='images/svg-select.svg' alt='Select Option'>
                </div>
                <p class='questions__item__title'>Select</p>
            </li>
            <li class='questions__item'>
                <div class='questions__item__image'>
                    <img src='images/svg-range.svg' alt='Range Option'>
                </div>
                <p class='questions__item__title'>Range Slider</p>
            </li>
            <li class='questions__item'>
                <div class='questions__item__image'>
                    <img src='images/svg-dots.svg' alt='More Options'>
                </div>
                <p class='questions__item__title'>Coming soon</p>
            </li>
        </ul>
    </div>
    <div class='wrapper wrapper-ranking'>
        <p class='ranking-title'>
            Share your survey and earn a spot in our hall of fame.
        </p>
        <ul class='ranking'>
            @foreach($surveys as $key => $survey)   
            <li class='ranking__item' onclick='addToClipboard({{$key}})'>
                <span class='icon'>
                    <img src='images/svg-star.svg' alt='More Options'>
                </span>
                <div class='copy' id='copy-{{$key}}'>
                    Copy to clipboard
                </div>
                <p class='title'>
                    {{$survey['title']}}
                </p>
                <p class='description'>
                {{$survey['desc']}}
                </p>
                <p class='created'>
                    created by: <b>{{$survey['createdBy']}}</b>
                </p>
            </li>
            @endforeach
        </ul>
    </div>
    <div class='wrapper-action'>
        <div class='action'>
            <p class='action__text'>
               Try it out, it's free!
            </p>
            <a href='{{ url("/get-started") }}' class='action__btn'>Start Creating!</a>
            <a href='{{ url("/") }}' class='action__btn'>Start Playing!</a>
        </div>
        
    </div>
</div>
@endsection

<script>
var surveys = {!! json_encode($surveys) !!}
function addToClipboard(key) {
  var code = surveys[key].code
  var dummy = document.createElement("input");
  document.body.appendChild(dummy);
  dummy.setAttribute("id", "dummy_id");
  document.getElementById("dummy_id").value=code;
  dummy.select();
  document.execCommand("copy");
  document.body.removeChild(dummy);
  var element = document.getElementById("copy-" + key);
  element.classList.add("clicked");
}
</script>

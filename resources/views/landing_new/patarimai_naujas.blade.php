@extends("layouts.landing_new")@section("title", "Patarimai tėvams")@section("content")
    <div class="row mt-5">
        <div class="col-md-6 col-sm-12  justify-content-center align-self-center">
            <h1 class="suggestion-main-title">{{$siteContent['title']}}</h1>
        </div>
        <div class="col-md-6 col-sm-12">
            <img class="img-fluid suggestion-main-photo" src="/uploads/pages/suggestions/{{ $siteContent['img'] }}">
        </div>
    </div>

   <div class="row">
       @foreach ($suggestions as $suggestion)
           <div class="col-12 w-100 mt-5 suggestion-main">
               <div class="suggestion-top mt-3 ml-5 mr-3">
                    <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}"> <h4 class="suggestion-title">{{$suggestion->title}}</h4>
               </div>
               @if (strlen($suggestion->description) > 1500)
                        <div class="text mt-3 ml-5 mr-5 mb-3 suggestion-description readmore" >{!! $suggestion->description !!}
                            <span class="readmore-link"></span>
                        </div>
                @else
                   <div class="text mt-4 ml-5 mr-5 mb-5 suggestion-description" >{!! $suggestion->description !!}</div>
               @endif
           </div>
       @endforeach
   </div>
@endsection



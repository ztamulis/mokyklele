@extends("layouts.landing_new")@section("title", "Komanda")@section("content")
                                                               <style>
                                                                   .profile--image {
                                                                       width: 200px;
                                                                       height: 200px;
                                                                       border-radius: 100%;
                                                                       margin: auto;
                                                                       background-position: center;
                                                                       background-size: cover;
                                                                       overflow: hidden;
                                                                       object-fit: cover;
                                                                   }
                                                               </style>
    <div class="row mt-5">
        <div class="col-md-12 col-sm-12 justify-content-center align-self-center">
            <h3 class="text-center" style="rgb(78, 219, 191)"><b>Mūsų komanda</b></h3>
        </div>

    </div>

   <div class="row">
       @foreach ($teamMembers as $member)
           @if($loop->index < 8)
           <div class="col-md-3 text-center col-sm-12 w-100 mt-5">
                    <img class="profile--image" src="{{asset('uploads/team_member/'.$member->img)}}">
               <h4 class="suggestion-title"><b>{{$member->full_name}}</b></h4>
                <div class="text mt-4 mb-5 suggestion-description" >{!! $member->description !!}</div>
           </div>
           @else
               <div class="col-md-6 col-sm-12 w-100 mt-5 text-center">
                   <img class="profile--image" src="{{asset('uploads/team_member/'.$member->img)}}">
                   <h4 class="suggestion-title"><b>{{$member->full_name}}</b></h4>
                   <div class="text mt-4 mb-5 suggestion-description" >{!! $member->description !!}</div>
               </div>
           @endif
       @endforeach
   </div>
@endsection



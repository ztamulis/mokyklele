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
           @if($loop->index < $loop->count - 2)
           <div class="col-md-3 text-center col-sm-12 w-100 mt-5">
                    <img class="profile--image" src="{{asset('uploads/team_member/'.$member->img)}}">
               <h6 class="suggestion-title mt-3"><b>{{$member->full_name}}</b></h6>
                <div class="text mt-2 mb-5 suggestion-description" >{!! $member->description !!}</div>
           </div>
           @else
               @if($loop->index == $loop->count - 2)
                   <div class="row">
                @endif
               <div class="col-md-6 col-sm-12 w-100 mt-5 text-center">
                   <img class="profile--image" src="{{asset('uploads/team_member/'.$member->img)}}">
                   <h6 class="suggestion-title mt-3"><b>{{$member->full_name}}</b></h6>
                   <div class="text mt-2 mb-5 suggestion-description" >{!! $member->description !!}</div>
               </div>
               @if($loop->last)
                   </div>
               @endif
           @endif
       @endforeach
   </div>
@endsection



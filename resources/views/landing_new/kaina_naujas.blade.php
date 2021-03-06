@extends("layouts.landing_new")@section("title", "Kaina")@section("content")
                                                               <style>
                                                                   .profile--image {
                                                                       width: 250px;
                                                                       height: 250px;
                                                                       background-position: center;
                                                                       background-size: cover;
                                                                       overflow: hidden;
                                                                       object-fit: cover;
                                                                   }
                                                               </style>

   <div class="row">
       <div class="col-md-4 col-sm-12 mt-5">
           <div class="row">
               <div class="col-md-12">
                   <img class="profile--image" src="{{asset('uploads/pages/price/'.$siteContent['first_block_first_img'])}}">
               </div>
               <div class="col-md-12">
                   <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_first_content'] !!}</div>
               </div>
           </div>
       </div>
       <div class="col-md-4 col-sm-12 mt-5">
           <div class="row">
               <div class="col-md-12">
                   <img class="profile--image" src="{{asset('uploads/pages/price/'.$siteContent['first_block_second_img'])}}">
               </div>
               <div class="col-md-12">
                   <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_second_content'] !!}</div>
               </div>
           </div>
       </div>
       <div class="col-md-4 text-center col-sm-12 mt-5">
           <div class="row">
               <div class="col-md-12">
                   <img class="profile--image" src="{{asset('uploads/pages/price/'.$siteContent['first_block_third_img'])}}">
               </div>
               <div class="col-md-12">
                   <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_third_content'] !!}</div>
               </div>
           </div>
       </div>
   </div>
   <hr>
   <div class="row">
       <div class="col-md-4 text-center w-75 col-sm-12 mt-3">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_first_content'] !!}</div>
       </div>
       <div class="col-md-4 text-center w-75 col-sm-12 mt-3">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_second_content'] !!}</div>
       </div>
       <div class="col-md-4 text-center w-75 col-sm-12 mt-3">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_third_content'] !!}</div>
       </div>
   </div>

   <div class="row">
       <div class="col-md-12 mt-0 text-center col-sm-12 w-100">
           <div class="text mb-5 suggestion-description" >{!! $siteContent['end_text'] !!}</div>
       </div>
   </div>
 <hr>
@endsection



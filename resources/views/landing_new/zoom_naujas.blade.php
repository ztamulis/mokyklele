@extends("layouts.landing_new")@section("title", "Kaip naudotis Zoom?")@section("content")




    <div class="row mt-3" style="background-color: #e9e9e9; padding: 50px">
        <div class="col-md-12 col-sm-12 mt-5">
            <h1 class="text-center" style="
            font-family: 'Playfair Display', 'Vollkorn', serif;
            font-size: 40px;
            font-weight: bold;
">{!! $siteContent['main_title'] !!}</h1>
        </div>
       <div class="col-md-6 col-sm-12 mt-5">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_left'] !!}</div>
       </div>
        <div class="col-md-6 col-sm-12 mt-5">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_right'] !!}</div>
        </div>
    </div>
   <hr>
    <div class="row mt-2" style="background-color: #e9e9e9; padding: 50px">
       <div class="col-md-6 col-sm-12 mt-5">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_left'] !!}</div>
       </div>
       <div class="col-md-6 col-sm-12 mt-5">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_right'] !!}</div>
       </div>
   </div>

   <div class="row mt-2">
       <iframe src="{!! $siteContent['video_url'] !!}" allowfullscreen="true" style="height: 400px; width: 100%;" frameborder="0">

       </iframe>
   </div>
 <hr>
@endsection



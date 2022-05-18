@extends("layouts.landing_new")@section("title", "Apie pamokas")@section("content")
<style>@media screen and (max-width: 768px) {
        .description-display-none {
            display: none;
        }
    }
</style>
    <div class="row mt-2 mb-2">
        <div class="col-md-4 col-sm-12 mt-4">
            <h1 class="text-center huge--blue" style="font-weight: bold;
    letter-spacing: 0;
    font-size: 80px;
    color: #0f65ef;">{!! $siteContent['main_title'] !!}</h1>
        </div>
       <div class="col-md-6 offset-1 col-sm-12 mt-5">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['main_description'] !!}</div>
       </div>
    </div>
   <hr>
    <div class="row mt-2">
        <div class="col-md-12">
            <h2 class="text-center"><b>{!! $siteContent['first_block_title'] !!}</b></h2>
        </div>
       <div class="col-md-3 col-sm-12 mt-2">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_first_description'] !!}</div>
           <div class="text mt-2 suggestion-description text-center d-md-none" >
               <a href="{!! $siteContent['first_block_first_url'] !!}"><b>UŽSIREGISTRUOTI</b></a>
           </div>
       </div>
       <div class="col-md-3 col-sm-12 mt-2">
           <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_second_description'] !!}</div>
           <div class="text mt-2 suggestion-description text-center d-md-none" >
               <a href="{!! $siteContent['first_block_second_url'] !!}"><b>UŽSIREGISTRUOTI</b></a>
           </div>
       </div>
        <div class="col-md-3 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_third_description'] !!}</div>
            <div class="text mt-2 suggestion-description text-center d-md-none" >
                <a href="{!! $siteContent['first_block_third_url'] !!}"><b>UŽSIREGISTRUOTI</b></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['first_block_fourth_description'] !!}</div>
            <div class="text mt-2 suggestion-description text-center d-md-none" >
                <a href="{!! $siteContent['first_block_fourth_url'] !!}"><b>UŽSIREGISTRUOTI</b></a>
            </div>

        </div>
   </div>
    <div class="row description-display-none">
        <div class="col-md-3 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description text-center" ><a href="{!! $siteContent['first_block_first_url'] !!}"><b>UŽSIREGISTRUOTI</b></a> </div>
        </div>
        <div class="col-md-3 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description text-center" ><a href="{!! $siteContent['first_block_second_url'] !!}"><b>UŽSIREGISTRUOTI</b></a> </div>
        </div>
        <div class="col-md-3 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description text-center" ><a href="{!! $siteContent['first_block_third_url'] !!}"><b>UŽSIREGISTRUOTI</b></a> </div>
        </div>
        <div class="col-md-3 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description text-center" ><a href="{!! $siteContent['first_block_fourth_url'] !!}"><b>UŽSIREGISTRUOTI</b></a> </div>
        </div>
    </div>
    <hr>

   <div class="row mt-3">
       <iframe src="{!! $siteContent['video_url'] !!}" allowfullscreen="true" style="height: 400px; width: 100%;" frameborder="0"></iframe>
   </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h2 class="text-center"><b>{!! $siteContent['second_block_title'] !!}</b></h2>
        </div>
        <div class="col-md-6 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_first_left'] !!}</div>
        </div>
        <div class="col-md-6 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_first_right'] !!}</div>
        </div>
        <div class="col-md-6 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_second_left'] !!}</div>
        </div>
        <div class="col-md-6 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_second_right'] !!}</div>
        </div>
        <div class="col-md-6 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_third_left'] !!}</div>
        </div>
        <div class="col-md-6 col-sm-12 mt-2">
            <div class="text mt-2 suggestion-description" >{!! $siteContent['second_block_third_right'] !!}</div>
        </div>
    </div>
@endsection



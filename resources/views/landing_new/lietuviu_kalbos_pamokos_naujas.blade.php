@extends("layouts.landing_new")@section("title", "Lietuvių kalbos pamokos")@section("content")
    <div class="row mt-5 justify-content-center align-self-center">
        <div class="col-md-6 col-sm-12  justify-content-center align-self-center">
            <h1 class="lithuanian-main-title">{{$siteContent['title']}}</h1>
            <div class="lithuanian-description">{!! $siteContent['description'] !!}</div>
        </div>
        <div class="col-md-6 col-sm-12  justify-content-center align-self-center">
            <img class="img-fluid suggestion-main-photo" src="/uploads/pages/languagecourses/{{ $siteContent['img'] }}">
        </div>
    </div>

   <div class="row pl-3">
       <div class="col-12 w-100 mt-4 mb-4 suggestion-main ">
           <div class="suggestion-top mt-5 ml-5 mr-5">
               <span class="lithuanian-first-box-title">{{$siteContent['first_box_title']}}</span>
           </div>
           <div class="row mt-3 ml-5 mr-5 no-gutters">
               <div class="col-md-6 pr-5">
                   <div class="display-first-block-array">
                       <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                       <h4 class="lithuanian-block-array">{!! $siteContent['first_box_array'][0] !!}</h4>
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="display-first-block-array">
                    <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                       <h4 class="lithuanian-block-array">{!! $siteContent['first_box_array'][1] !!}</h4>
                   </div>
               </div>
           </div>
           <div class="row mt-3 ml-5 mr-5 mb-4 no-gutters">
               <div class="col-md-6 pr-5">
                   <div class="display-first-block-array">
                       <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                       <h4 class="lithuanian-block-array">{!! $siteContent['first_box_array'][2] !!}</h4>
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="display-first-block-array">
                       <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                       <h4 class="lithuanian-block-array">{!! $siteContent['first_box_array'][3] !!}</h4>
                   </div>
               </div>
           </div>
       </div>
       <div id="courses-buy" class="w-100">
           @if(!empty($siteContent['main_component_courses']))
                   @include(\App\Http\Helpers\PageContentHelper::getComponent($siteContent['main_component_courses']))
           @endif
       </div>
       <div class="row mt-5">
           <div class="col-md-12 col-sm-12 justify-content-center align-self-center">
               <h1 class="second-block-title mb-3">{{$siteContent['second_box_title']}}</h1>
               <div class="second-block-description">{!! $siteContent['second_box_description'] !!}</div>
           </div>
           <div class="col-md-4 col-sm-12 mt-3 language-level-group">
               <div class="color background--green pr-1"></div>
               <div class="" style="">
                   <h1 class="second-block-group-title mt-2 mb-3">{{$siteContent['second_box_name'][0]}}</h1>
               </div>
               <div class="mt-1">
                    <div class="second-block-group-description mt-5">{!! $siteContent['second_box_content'][0] !!}</div>
               </div>
           </div>
           <div class="col-md-4 col-sm-12 mt-3 language-level-group">
               <div class="display-first-block-array">
                   <img class="img-fluid mr-3 suggestion-img" src="{{asset('assets/img/other/Group 44.jpg')}}">
                   <h1 class="second-block-group-with-img-title mt-2 mb-3">{{$siteContent['second_box_name'][1]}}</h1>
               </div>
               <div class="second-block-group-description mt-5" style="margin-top: 2rem!important">{!! $siteContent['second_box_content'][1] !!}</div>
           </div>
           <div class="col-md-4 col-sm-12 mt-3 language-level-group">
               <div class="color background--red"></div>
               <div class="" >
                   <h1 class="second-block-group-title mt-2 mb-3  pl-1">{{$siteContent['second_box_name'][2]}}</h1>
               </div>
               <div class="second-block-group-description mt-5">{!! $siteContent['second_box_content'][2] !!}</div>
           </div>
       </div>



       <div class="row mt-5 w-100">
           <div class="col-md-12 pr-5">
               <div class="display-first-block-array">
                   <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                   <h2 class="second-block-title">{!! $siteContent['third_box_name'][0] !!}</h2>
               </div>
               <h4 class="third-block-description">{!! $siteContent['third_box_content'][0] !!}</h4>
               @if(!empty($siteContent['main_component_questions']))
                   <div class="row" id="question-form-group">
                       @include(\App\Http\Helpers\PageContentHelper::getComponent($siteContent['main_component_questions']))
                   </div>
               @endif
           </div>
           <div class="col-md-12">
               <h1 class="third-block-title mb-5 pr-2">{{$siteContent['third_box_title']}}</h1>
           </div>

           <div class="col-md-12 pr-5">
               <div class="display-first-block-array">
                   <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                   <h2 class="second-block-title">{!! $siteContent['third_box_name'][1] !!}</h2>
               </div>
               <h4 class="third-block-description">{!! $siteContent['third_box_content'][1] !!}</h4>
           </div>
           <div class="col-md-12 mt-3">
               <div class="display-first-block-array">
                   <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                   <h2 class="second-block-title">{!! $siteContent['third_box_name'][2] !!}</h2>
               </div>
               <h4 class="third-block-description">{!! $siteContent['third_box_content'][2] !!}</h4>
           </div>
           <div class="col-md-12 pr-5 mt-3">
               <div class="display-first-block-array">
                   <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                   <h2 class="second-block-title">{!! $siteContent['third_box_name'][3] !!}</h2>
               </div>
               <h4 class="third-block-description">{!! $siteContent['third_box_content'][3] !!}</h4>
           </div>
           <div class="col-md-12 mt-3">
               <div class="display-first-block-array">
                   <img class="img-fluid mt-2 mr-2 suggestion-img" src="{{asset('assets/img/other/Group 21.png')}}">
                   <h2 class="second-block-title">{!! $siteContent['third_box_name'][4] !!}</h2>
               </div>
               <h4 class="third-block-description">{!! $siteContent['third_box_content'][4] !!}</h4>
           </div>
       </div>
   </div>
@endsection



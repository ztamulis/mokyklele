@extends("layouts.landing_new")@section("title", "Suagusiųjų kursai")@section("content")
    <div class="container--other">
    <div class="row mt-5 mb-5">
        <div class="col-md-6 col-sm-12  justify-content-center align-self-center">
            <img class="img-fluid suggestion-main-photo" src="uploads/pages/courses_adults/{{ $siteContent['main_img'] }}">

        </div>
        <div class="col-md-6 col-sm-12">
            <div>
                <h1 class="suggestion-main-title">{{ $siteContent['main_title'] }}</h1>
            </div>
            <div>
                <div class="meeting-description mt-3">{!! $siteContent['main_description'] !!}</div>
            </div>
        </div>
    </div>
        @if(!empty($siteContent['main_component']))
                @include(\App\Http\Helpers\PageContentHelper::getComponent($siteContent['main_component']))
        @endif

        @if(!empty($siteContent['second_component']))
            @include(\App\Http\Helpers\PageContentHelper::getComponent($siteContent['second_component']))
        @endif
    </div>
    <div class="row mt-5 mb-5">
        @if(!empty($siteContent['bottom_description']))
            <div>
                <div class="meeting-description mt-3">{!! $siteContent['bottom_description'] !!}</div>
            </div>
        @endif
    </div>
@endsection


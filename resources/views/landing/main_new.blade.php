@extends("layouts.landing_new")@section("title", "")@section("content")

    <div class="row mt-5 mb-5 justify-content-center align-self-center">
        <div class="col-md-6 col-sm-12  justify-content-center align-self-center">
            <h1 class="home-main-title">{{$siteContent['main_title']}}</h1>
            <div class="home-main-description">{!! $siteContent['main_description'] !!}</div>
            <a href="{{$siteContent['main_button_url']}}" class="home-main-button text-white">{{$siteContent['main_button_text']}}</a>
        </div>
        <div class="col-md-6 col-sm-12  justify-content-center align-self-center">
            <img class="img-fluid home-main-photo" width="380" height="380" src="/uploads/pages/home/{{ $siteContent['main_img'] }}">
        </div>
    </div>

    <div class="row mt-5 justify-content-center align-self-center">
        <div class="col-md-4 col-sm-12  justify-content-center align-self-center text-lg-right pr-4">
            <span class="home-block-title">{{ $siteContent['first_block_title'] }}</span>
        </div>
        <div class="col-md-8 col-sm-12  justify-content-center align-self-center" style="left: 10px;">
            <div class="home-block-description">
                <div class="home-block-box-circle-left">
                    <img src="{{asset('assets/img/other/emotxd-smile.svg')}}" class="rounded-circle home-block-box-img-left" alt="Cinque Terre" width="304" height="236">
                </div>
                <div class="pt-4 pl-5 pr-5 pb-4">
                    <label>{!! $siteContent['first_block_description'] !!}</label><br>
                    <a class="home-block-url-title" href="{{$siteContent['first_block_button_url']}}"><span>{{$siteContent['first_block_button_text']}} →</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 justify-content-center align-self-center">
        <div class="col-md-4 col-sm-12 order-md-2 justify-content-center align-self-center pl-md-5 mb-md-0 mb-sm-5">
            <span class="home-block-title">{{ $siteContent['second_block_title'] }}</span>
        </div>
        <div class="col-md-8 col-sm-12 order-md-1 justify-content-center align-self-center" style="left: 10px;">
            <div class="home-block-description">
                <div class="home-block-box-circle-right">
                    <img src="{{asset('assets/img/other/like.svg')}}" class="rounded-circle home-block-box-img-right" alt="Cinque Terre" width="304" height="236">
                </div>
                <div class="pt-4 pl-5 pr-5 pb-4">
                    <label>{!! $siteContent['second_block_description'] !!}</label><br>
                    <a class="home-block-url-title" href="{{$siteContent['second_block_button_url']}}"><span>{{$siteContent['second_block_button_text']}} →</span></a>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-5 justify-content-center align-self-center">
        <div class="col-md-4 col-sm-12  justify-content-center align-self-center text-lg-right pr-4">
            <span class="home-block-title">{{ $siteContent['third_block_title'] }}</span>
        </div>
        <div class="col-md-8 col-sm-12  justify-content-center align-self-center" style="left: 10px;">
            <div class="home-block-description">
                <div class="home-block-box-circle-left">
                    <img src="{{asset('assets/img/other/screen.svg')}}" class="rounded-circle home-block-box-img-left" alt="Cinque Terre" width="304" height="236">
                </div>
                <div class="pt-4 pl-5 pr-5 pb-4">
                    <label>{!! $siteContent['third_block_description'] !!}</label><br>
                    <a class="home-block-url-title" href="{{$siteContent['third_block_button_url']}}"><span>{{$siteContent['third_block_button_text']}} →</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: -100px;">
        <div class="landing--col-1">
            <img src="https://mokyklelepasaka.rfox.cloud/uploads/page-uploads/1-NLJ4fiw05cg77KZR.png" class="img-fluid" style="margin-bottom: -10px;max-height: 361px;">
        </div>
        <div class="carousel" data-image1="https://mokyklelepasaka.lt/uploads/page-uploads/23-Tr0GHvyjuQVFK3fb.png" data-image2="https://mokyklelepasaka.lt/uploads/page-uploads/23-aGQHSYzOwWZDkz8C.png" data-image3="https://mokyklelepasaka.lt/uploads/page-uploads/23-PJ4XKljXzzD0JPjc.png" data-image4="" data-image5="" data-image6="" data-image7="" data-image8="" data-image9="" id="jssor_0" data-jssor-slider="1" style="height: 152.69901315789474px; width: 483.546875px; visibility: visible;" data-initialized="0">
            <div style="display: block; position: absolute; width: 483.546875px; height: 152.69901315789474px;" data-vvveb-disabled="true">
                <div style="display: block; position: absolute; width: 950px; height: 300px; top: -73.65049342105263px; left: -233.2265625px; transform: scale(0.5095057072368421);">
                    <div data-u="slides" style="height: 300px; width: 950px; margin: 0px; padding: 0px; transform-style: flat; z-index: 0; position: absolute; pointer-events: none; top: 0px; left: 0px;">
                        <div style="width: 950px; height: 300px; top: 0px; left: 0px; display: block; position: absolute; z-index: 0;"></div>
                    </div>
                    <div data-u="slides" style="height: 300px; width: 950px; margin: 0px; padding: 0px; transform-style: flat; z-index: 0; position: absolute; overflow: hidden; top: 0px; left: 0px;">
                        <div style="width: 950px; height: 300px; top: 0px; left: -950px; position: absolute; z-index: 1; overflow: hidden; transform-style: flat;"><div data-u="bg" style="width: 950px; height: 300px; top: 0px; left: 0px; display: block; position: absolute; overflow: hidden; background-color: rgba(0, 0, 0, 0); background-image: none;">
                                <img data-u="image" src="https://mokyklelepasaka.lt/uploads/page-uploads/23-Tr0GHvyjuQVFK3fb.png" border="0" data-events="auto" data-display="block" style="width: 950px; height: 300px; top: 0px; left: 0px; display: block; position: absolute; max-width: 10000px; z-index: 1;">
                            </div>
                        </div>
                        <div style="width: 950px; height: 300px; top: 0px; left: 0px; position: absolute; z-index: 1; overflow: hidden; transform-style: flat;">
                            <div data-u="bg" style="width: 950px; height: 300px; top: 0px; left: 0px; display: block; position: absolute; overflow: hidden; background-color: rgba(0, 0, 0, 0); background-image: none;"><img data-u="image" src="https://mokyklelepasaka.lt/uploads/page-uploads/23-aGQHSYzOwWZDkz8C.png" border="0" data-events="auto" data-display="block" style="width: 950px; height: 300px; top: 0px; left: 0px; display: block; position: absolute; max-width: 10000px; z-index: 1;">
                            </div>
                        </div>
                        <div style="width: 950px; height: 300px; top: 0px; left: 950px; position: absolute; z-index: 1; overflow: hidden; transform-style: flat;">
                            <div data-u="bg" style="width: 950px; height: 300px; top: 0px; left: 0px; display: block; position: absolute; overflow: hidden; background-color: rgba(0, 0, 0, 0); background-image: none;">
                                <img data-u="image" src="https://mokyklelepasaka.lt/uploads/page-uploads/23-PJ4XKljXzzD0JPjc.png" border="0" data-events="auto" data-display="block" style="width: 950px; height: 300px; top: 0px; left: 0px; display: block; position: absolute; max-width: 10000px; z-index: 1;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<x-user>
    <div class="client--dashboard">
        @if(isset($message))
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
                </div>
            </div>
        @endif
        @if(Session::has('message'))
            <div class="row text-center" id="flash-message" style="display: block;">
                <div class="col-xl-8 offset-xl-2">
                    <div class="alert alert-primary text-center" role="alert"><span>{{ Session::get('message') }}</span></div>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <div class="alert alert-primary text-center" role="alert">
                        <span>Klaida!<br>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </span>
                    </div>
                </div>
            </div>
        @endif
        <h1 class="text-center">Puslapių informacijos redagavimas</h1>
        <div class="row mt-5 text-center">
            <div class="col-lg-3 col-md-12 mb-3">
                <a href="{{route('pages.lithuanian-courses-children.edit')}}">
                    <button class="button btn-primary">
                        <i class="fa fa-cc-discover"></i><span>Lietuvių kalbos kursų puslapis</span>
                    </button>
                </a>
            </div>
            <div class="col-lg-3 col-md-12 mb-3">
                <a href="{{route('pages.home-page.edit')}}">
                    <button class="button btn-primary">
                        <i class="fa fa-cc-discover"></i><span>Pagrindinis puslapis</span>
                    </button>
                </a>
            </div>
            <div class="col-lg-3 col-md-12 mb-3">
                <a href="{{route('pages.suggestions-config.list.index')}}">
                    <button class="button btn-primary">
                        <i class="fa fa-cc-discover"></i><span>Patarimai tėvams</span>
                    </button>
                </a>
            </div>
            <div class="col-lg-3 col-md-12">
                <a href="{{route('pages.introductions-config.introductions.index')}}">
                <button class="button btn-primary">
                    <i class="fa fa-cc-discover"></i><span>Vieši susitikimai</span>
                </button>
                </a>
            </div>
        </div>
            <div class="row mt-5 text-center">
                <div class="col-lg-3 col-md-12 mb-3">
                    <a href="{{route('pages.courses-adults.edit')}}">
                        <button class="button btn-primary">
                            <i class="fa fa-cc-discover"></i><span>Suaugusiųjų kursai</span>
                        </button>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 mb-3">
                    <a href="{{route('pages.team-member.index')}}">
                        <button class="button btn-primary">
                            <i class="fa fa-cc-discover"></i><span>Komanda</span>
                        </button>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 mb-3">
                    <a href="{{route('pages.free-lessons.edit')}}">
                        <button class="button btn-primary">
                            <i class="fa fa-cc-discover"></i><span>Nemokama pamoka</span>
                        </button>
                    </a>
                </div>
            </div>
    </div>
</x-user>
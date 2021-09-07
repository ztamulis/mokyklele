<x-app-layout>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <h1 class="text-center mt-5 mb-5">Naujas kuponas</h1>
    @if (!empty($errors))
        @foreach($errors->default->messages() as $error)
            <h3 class="text-danger">{{$error[0]}}</h3>
        @endforeach
    @endif
    <form action="/dashboard/coupons" method="POST">
        @csrf
        @method("POST")
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="form-text bold mb-1">Kupono kodas (Maksimalus simbolių skaičius: 32)</small>
                            <input class="form-control" type="text" name="code" placeholder="Sekmadienis-nuolaida-2032" value="{{old('code')}}">
                        </div>
                    </div>
                </div>
            </div>
            @if (!empty($groups))
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <small class="form-text bold mb-1">Grupės kurioms priskiriamas kuponas (Nebūtinas laukas)</small>
                                <select class="form-select" name="groups[]" multiple aria-label="multiple select example" style="width: 100%;">
                                    @foreach ($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}} - {{$group->color()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <small class="form-text bold mb-1">Kupono tipas</small>
                        <select class="form-select" name="type" aria-label="Default select example">
                            <option {{old('discount') === 'fixed' ? 'selected' : ''}} value="fixed">Fiksuotas</option>
                            <option {{old('discount') === 'percent' ? 'selected' : ''}} value="percent">Procentas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="form-text bold mb-1">Nuolaidos dydis (Pagal tipą: procentas arba fiksuotas dydis)</small>
                            <input class="form-control" type="number" name="discount" placeholder="0" value="{{old('discount')}}" min="1">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="form-text bold mb-1">Panaudojimų limitas</small>
                            <input class="form-control" type="number" name="use_limit" placeholder="0" value="{{old('use_limit')}}" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <small class="form-text bold">Galiojimo pabaiga ({{ date("H:i") }} formatu,  {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                                <input class="form-control" type="datetime-local" name="expires_at" placeholder="{{ date("H:i") }}" value="{{old('expires_at')}}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                                <small class="form-text bold mb-1">Aktyvus</small>
                                <select class="form-select" name="active" aria-label="Default select example">
                                    <option {{old('active') == 0 ? 'selected' : ''}} value="0">Ne</option>
                                    <option {{old('active') == 1 ? 'selected' : ''}} value="1">Taip</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-light" style="margin: 0px 4px 0px;" type="submit">Sukurti</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-app-layout>

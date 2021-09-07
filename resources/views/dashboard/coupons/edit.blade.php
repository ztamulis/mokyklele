<x-app-layout>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <h1 class="text-center mt-5 mb-5">Naujas kuponas</h1>
    @if (!empty($errors))
        @foreach($errors->default->messages() as $error)
            <h3 class="text-danger">{{$error[0]}}</h3>
        @endforeach
    @endif
    <form action="/dashboard/coupons/{{$coupon->id}}" method="POST">
        @csrf
        @method("PUT")
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="form-text bold mb-1">Kupono kodas (Maksimalus simbolių skaičius: 32)</small>
                            <input class="form-control" type="text" name="code" placeholder="Sekmadienis-nuolaida-2032" value="{{!empty(old('code')) ? old('code') : $coupon->code}}">
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
                                        <option {{ !empty($coupon->groups) && isset(array_flip($coupon->groups)[$group->id]) ? 'selected' : ''}}  value="{{$group->id}}">{{$group->name}} - {{$group->color()}}</option>
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
                            <option {{old('discount') || $coupon->discount === 'fixed' ? 'selected' : ''}} value="fixed">Fiksuotas</option>
                            <option {{old('discount') || $coupon->discount === 'percent' ? 'selected' : ''}} value="percent">Procentas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="form-text bold mb-1">Nuolaidos dydis (Pagal tipą: procentas arba fiksuotas dydis)</small>
                            <input class="form-control" type="number" name="discount" placeholder="0" value="{{!empty(old('discount')) ? old('discount') : $coupon->discount}}" min="1">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <small class="form-text bold mb-1">Panaudojimų limitas</small>
                            <input class="form-control" type="number" name="use_limit" placeholder="0" value="{{!empty(old('use_limit')) ? old('use_limit') : $coupon->use_limit}}" min="0">
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
                                <input class="form-control" type="datetime-local" name="expires_at" placeholder="{{ date("H:i") }}" value="{{!empty(old('expires_at')) ? old('expires_at') : $coupon->expires_at}}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-select" name="active" aria-label="Default select example">
                                <option {{old('active') == 1 ? 'selected' || $coupon->type == 1 : ''}} value="1">Taip</option>
                                <option {{old('active') == 0 ? 'selected' || $coupon->type == 1 : ''}} value="0">Ne</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button class="btn btn-light" style="margin: 0px 4px 0px;" type="submit">Pakeisti</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>

<x-app-layout>
    @if(isset($message))
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
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
    <h3 class="text-dark mb-4">Atnaujinti grupę</h3>
    <div class="card shadow"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/groups/{{ $group->slug }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="form-group"><small class="form-text text-muted">Pavadinimas</small><input class="form-control" type="text" name="name" placeholder="Geltonoji grupė (Pavasaris)" value="{{ $group->name }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Trump. aprašymas</small><input class="form-control" type="text" name="display_name" placeholder="Geltonoji" value="{{ $group->display_name }}"></div>
                        <div class="form-group">
                            <small class="form-text text-muted">Aprašymas</small>
                            <textarea class="form-control summernote" name="description">{!! $group->description !!}</textarea>
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Informacija</small>
                            <textarea class="form-control summernote" name="information">{!! $group->information !!}</textarea>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Kaina (£)</small><input class="form-control" type="number" name="price" placeholder="119" value="{{ $group->price }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Vietų skaičius</small><input class="form-control" type="number" name="slots" placeholder="10" value="{{ $group->slots }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Laikas ({{ date("H:i") }} formatu,  {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                            <input class="form-control" type="text" name="time" placeholder="{{ date("H:i") }}" value="{{ !empty($group->time) ? $group->adminTime->format("H:i") : "" }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Laikas 2 ({{ date("H:i") }} formatu,  {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                            <input class="form-control" type="text" name="time_2" placeholder="{{ date("H:i") }}" value="{{ !empty($group->time_2) ? $group->adminTime2->format("H:i") : "" }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Pradžios data ({{ date("H:i") }} formatu,  {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                            <input class="form-control" type="datetime-local" name="start_date" placeholder="{{ date("H:i") }}" value="{{ $group->start_date ? \Carbon\Carbon::parse($group->start_date)->format("Y-m-d\TH:i") : "00:00" }}"></div>
                        <div class="form-group"><small class="form-text text-muted">pabaigos data ({{ date("H:i") }} formatu,  {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                            <input class="form-control" type="datetime-local" name="end_date" placeholder="{{ date("H:i") }}" value="{{ $group->end_date ? \Carbon\Carbon::parse($group->end_date)->format("Y-m-d\TH:i") : "00:00" }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Kurso ilgis (savaitėmis)</small><input class="form-control" type="number" name="course_length" placeholder="1" max="52" value="{{ $group->course_length }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Tipas</small>
                            <select class="form-control" name="type" required>
                                <option @if($group->type == "yellow") selected @endif value="yellow">Geltona (2-4m.)</option>
                                <option @if($group->type == "green") selected @endif value="green">Žalia (5-6m.)</option>
                                <option @if($group->type == "blue") selected @endif value="blue">Mėlyna (7-9m.)</option>
                                <option @if($group->type == "red") selected @endif value="red">Raudona (10-13m.)</option>
                                <option @if($group->type == "individual") selected @endif value="individual">Individualios pamokos</option>
                                <option @if($group->type == "no_type") selected @endif value="no_type">Be tipo</option>

                            </select>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Mokama</small>
                            <select class="form-control" name="paid" required>
                                <option @if($group->paid == 1) selected @endif value="1">Mokama</option>
                                <option @if($group->paid == 0) selected @endif value="0">Nemokama</option>
                            </select>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Amžiaus kategorija</small>
                            <select class="form-control" name="age_category" required>
                                @foreach (App\Models\Group::$FOR_TRANSLATE as $key => $value)
                                    <option @if($group->age_category == $key) selected @endif value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Vieta</small>
                            <ul id="sortable">
                                @foreach(\App\Models\Group::orderBy("weight", "ASC")->get() as $i => $g)
                                    <li class="ui-state-default">
                                        <small>#g{{ $g->id }}</small> ∙ {{ $g->color() }} ∙ {{ $g->name }} ∙ {{ $g->display_name }} ∙ {{ $g->adminTime ? $g->adminTime->format("H:i") : "00:00" }}
                                        <input type="hidden" name="weight[]" id="{{ $g->id }}" value="{{ $g->weight }}|{{ $g->id }}" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-2" name="hidden" value="1" @if($group->hidden) checked @endif ><label class="form-check-label" for="formCheck-2">Paslėpta</label></div>
                        <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti grupę</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready(function() {
            $("#sortable").sortable({
                stop: function(ev, ui) {
                    var children = $('#sortable').sortable('refreshPositions').children();
                    console.log('Positions: ');
                    $.each(children, function() {
                        $(this).find('input[type="hidden"]').val($(this).index() + "|" + $(this).find('input[type="hidden"]').attr('id'));
                    });
                }
            });
            $("#sortable").disableSelection();

        });
    </script>
</x-app-layout>
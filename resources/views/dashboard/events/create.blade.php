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
    <h3 class="text-dark mb-4">Pridėti užsiėmimą</h3>
    <div class="card"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/events" method="POST">
                        @csrf
                        <div class="form-group method-selection"><small class="form-text text-muted">Užsiėmimo kūrimo metodas</small>
                            <label><input type="radio" name="create_method" value="single" @if(old('create_method') == 'single') checked @endif > Kurti vieną užsiėmimą</label><br>
                            <label><input type="radio" name="create_method" value="multi" @if(old('create_method') == 'multi') checked @endif > Kurti daug užsiėmimų (batch)</label>
                        </div>
                        {{--@if(old('create_method') != 'single')
                        <div class="form-group create--method--single" @if(old('create_method') != 'single') style="display: none;" @endif >
                            <small class="form-text text-muted">Data ({{ date("Y-m-d H:i") }} formatu, GMT)</small>
                            <input class="form-control" type="datetime-local" name="date_at" placeholder="{{ date("Y-m-d H:i") }}" value="{{ old("date_at") }}">
                        </div>
                        @endif--}}
                        {{-- @if(old('create_method') != 'multi')--}}
                            {{--<div class="form-group create--method--multi" @if(old('create_method') != 'multi') style="display: none;" @endif >--}}
                            <div class="form-group">
                                <small class="form-text text-muted">Data ({{ date("Y-m-d H:i") }} formatu, {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                                <input class="form-control" type="datetime-local" name="date_at" placeholder="{{ date("Y-m-d\TH:i") }}" value="{{ old("date_at") }}">
                            </div>
                            <div class="form-group create--method--multi" @if(old('create_method') != 'multi') style="display: none;" @endif >
                                <small class="form-text text-muted">Pamokų skaičius</small>
                                <input class="form-control" type="number" name="date_at_count" placeholder="14" value="{{ old("date_at_count") }}">
                            </div>
                            <div class="form-group create--method--multi" @if(old('create_method') != 'multi') style="display: none;" @endif >
                                <small class="form-text text-muted">Pamokų intervalas (dienomis)</small>
                                <input class="form-control" type="number" name="date_at_interval" placeholder="7" value="{{ old("date_at_interval") }}">
                            </div>
                            <div class="form-group"><small class="form-text text-muted">Pavadinimas</small><input class="form-control" type="text" name="name" placeholder="Pamoka" value="{{ old("name") }}" maxlength="64"></div>
                            <div class="form-group">
                                <small class="form-text text-muted">Aprašymas</small>
                                <textarea class="form-control summernote" name="description">{!! old("description") !!}</textarea>
                            </div>
                            <div class="form-group"><small class="form-text text-muted">Zoom nuoroda</small><input class="form-control" type="text" name="join_link" placeholder="https://" value="{{ old("join_link") }}"></div>
                            <div class="form-group">
                                <small class="form-text text-muted">Priskirta grupėms</small>
                                <div class="form-check">
                                    <div class="table-responsive">
                                        <table class="table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Tipas</th>
                                                    <th>Grupės pavadinimas</th>
                                                    <th>Laikas</th>
                                                    <th>Trumpas aprašymas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($groups as $group)
                                                <tr>
                                                    <td class="text-right"><input class="form-check-input" type="checkbox" id="formCheck-{{ $group->id }}" name="groups[]" value="{{ $group->id }}"></td>
                                                    <td><div class="color--small background--{{ $group->type }}"></div> {{ $group->color() }}</td>
                                                    <td>#g{{ $group->id }} {{ $group->name }}</td>
                                                    <td>{{ $group->time ? $group->adminTime->format("H:i") : "00:00" }} <small>({{ $group->adminTimeModifier }})</small></td>
                                                    <td>{{ $group->display_name }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                {{-- @foreach($groups as $group)
                                     <div class="form-check">
                                         <input class="form-check-input" type="checkbox" id="formCheck-{{ $group->id }}" name="groups[]" value="{{ $group->id }}">
                                         <label class="form-check-label" for="formCheck-{{ $group->id }}"> <div class="color background--{{ $group->type }}"></div> {{ $group->name }}</label>
                                    </div>
                                @endforeach
                            </div>--}}
                            <div class="form-group"><small class="form-text text-muted">Mokytojas</small>
                            <select class="form-control" name="teacher_id" required>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }} {{ $teacher->surname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Užsiėmimo tipas</small>
                            <select class="form-control" name="type" required>
                                <option value="lesson">Pamoka</option>
                                <option value="individual">Individuali pamoka</option>
                                <option value="free">Nemokama pamoka</option>
                            </select>
                        </div>
                        <div class="form-group"><button class="btn btn-primary" type="submit">Pridėti naują užsiėmimą</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <script>

            $('#dataTable thead tr').clone(true).appendTo( '#dataTable thead' );
            $('#dataTable thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                if(title == ""){
                    return;
                }
                $(this).html( '<input type="text" placeholder="Ieškoti '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table1.column(i).search() !== this.value ) {
                        table1
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var table1 = $('#dataTable').DataTable( {
                orderCellsTop: true,
                paging: false,
            } );

            window.createMethod = "single";
            $('[name="create_method"]').change(function() {
                var method = $(this).val();
                window.createMethod = method;
                updateCreateMethodInputs();
            });

            function updateCreateMethodInputs() {
                if(window.createMethod == "single") {
                    $(".create--method--multi").hide();
                    $(".create--method--single").show();
                }else if(window.createMethod == "multi") {
                    $(".create--method--multi").show();
                    $(".create--method--single").hide();
                }
            }

            setInterval(function () {
                if(!$("[name=create_method]:checked").length){
                    $(".form-group:not(.method-selection)").hide();
                }else{
                    $(".form-group:not(.method-selection)").show();
                    updateCreateMethodInputs();
                }
            },200);

        </script>

</x-app-layout>
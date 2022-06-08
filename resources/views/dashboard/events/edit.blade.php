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
    <h3 class="text-dark mb-4">Redaguoti užsiėmimą</h3>
    <div class="card"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/events/{{ $event->id }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="form-group"><small class="form-text text-muted">Pavadinimas</small><input class="form-control" type="text" name="name" placeholder="Pamoka" value="{{ $event->name }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Data ({{ Carbon\Carbon::now()->timezone('Europe/London')->format('Y-m-d H:i') }} formatu, {{ \App\TimeZoneUtils::currentGmtModifierText() }})</small>
                            <input class="form-control" type="datetime-local" name="date_at" placeholder="{{ \App\TimeZoneUtils::updateTime($event->date_at->timezone('Europe/London'), $event->updated_at)->format('Y-m-d\TH:i')}}" value="{{ \App\TimeZoneUtils::updateTime($event->date_at->timezone('Europe/London'), $event->updated_at)->format('Y-m-d\TH:i')}}">
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Aprašymas</small>
                            <textarea class="form-control summernote" name="description">{!! $event->description !!}</textarea>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Zoom nuoroda</small><input class="form-control" type="text" name="join_link" placeholder="https://" value="{{ $event->join_link }}" ></div>
                    {{--<div class="form-group">
                        <small class="form-text text-muted">Priskirta grupėms</small>
                        @foreach($groups as $group)

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="formCheck-{{ $group->id }}" name="groups[]" value="{{ $group->id }}" @if($event->groups->contains($group->id)) checked @endif >
                                <label class="form-check-label" for="formCheck-{{ $group->id }}">{{ $group->name }}</label>
                            </div>
                            @endforeach
                        </div>--}}
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
                                                <td class="text-right"><input class="form-check-input" type="checkbox" id="formCheck-{{ $group->id }}" name="groups[]" value="{{ $group->id }}" @if($event->groups->contains($group->id)) checked @endif ></td>
                                                <td><div class="color--small background--{{ $group->type }}"></div> {{ $group->color() }}</td>
                                                <td>#g{{ $group->id }} {{ $group->name }}</td>
                                                <td>{{ $group->time ? \App\TimeZoneUtils::updateHours($group->time, $group->created_at) : "00:00" }} <small>{{ \App\TimeZoneUtils::dateGmtModifierText($group->date_at) }}</small></td>
                                                <td>{{ $group->display_name }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Mokytojas</small>
                            <select class="form-control" name="teacher_id" required>
                                @foreach($teachers as $teacher)
                                    <option @if($event->teacher_id == $teacher->id) selected @endif value="{{ $teacher->id }}">{{ $teacher->name }} {{ $teacher->surname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Užsiėmimo tipas</small>
                            <select class="form-control" name="type" required>
                                <option @if($event->type == "lesson") selected @endif value="lesson">Pamoka</option>
                                <option @if($event->type == "individual") selected @endif value="individual">Individuali pamoka</option>
                                <option @if($event->type == "free") selected @endif value="free">Nemokama pamoka</option>
                                <option @if($event->type == "bilingualism_consultation") selected @endif value="free">Dvikalbystės konsultacija</option>
                            </select>
                        </div>
                        <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti užsiėmimą</button></div>
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
                paging: false
            } );

        </script>
</x-app-layout>
<x-user>
    <div class="container--other">
    @if(isset($message))
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
            </div>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="row">
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
    <h3 class="text-dark mb-4">Užsiėmimai</h3>
    <div class="card">
        <div class="card-body">
                <div class="row">
                    <div class="col-lg-2 col-sm-12">
                        <label>Pavadinimas :</label>
                        <input type='text' value='' class='form-control filter' data-column-index='1'>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <label>Laikas :</label>
                        <input type='text' value='' class='form-control filter' data-column-index='2'>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <label>Grupė :</label>
                        <input type='text' value='' class='form-control filter' data-column-index='3'>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <label>Mokytojas :</label>
                        <input type='text' value='' class='form-control filter' data-column-index='4'>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <label>Tipas :</label>
                        <input type='text' value='' class='form-control filter' data-column-index='5'>
                    </div>
                </div>
            <div class="table-responsive table mt-2" id="tableDiv" role="grid" aria-describedby="tableDiv_info">
                @if(count($events))
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th class="no-sort"><input type="checkbox" data-select-all></th>
                                <th>Pavadinimas</th>
                                <th>Laikas ({{ \App\TimeZoneUtils::currentGmtModifierText() }})</th>
                                <th>Grupė</th>
                                <th>Mokytojas</th>
                                <th>Tipas</th>
                                <th class="no-sort"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td><input type="checkbox" data-select value="{{ $event->id }}"></td>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ $event->adminTime->format("Y-m-d H:i") }}</td>
                                    <td>
                                        @foreach($event->groups as $group)
                                            <div class="color--small background--{{ $group->type }}"></div> <small>#g{{ $group->id }}</small> {{ $group->name }} <small>{{ $group->adminTime->format("H:i") }}</small>
                                        @endforeach
                                    </td>
                                    <td>@if($event->teacher){{ $event->teacher->name }} {{ $event->teacher->surname }} @else ? @endif</td>
                                    <td>{{ $event->typeText() }}</td>
                                    <td class="text-right">
                                        <a href="/dashboard/events/{{ $event->id }}/attendances" class="btn btn-primary" style="margin: 0px 4px 0px;">Lankomumas</a>
                                        @if(Auth::user()->role == "admin")
                                            <a href="/dashboard/events/{{ $event->id }}/clone" class="btn btn-success" style="margin: 0px 4px 0px;">Dublikuoti</a>
                                            <a href="/dashboard/events/{{ $event->id }}/edit" class="btn btn-warning" style="margin: 0px 4px 0px;">Redaguoti</a>
                                            <form action="/dashboard/events/{{ $event->id }}" data-delete method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti grupę?')" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Ištrinti</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    Nėra priskirtų arba sukurtų užsiėmimų.
                @endif
            </div>
            @if(Auth::user()->role == "admin")
                <div class="row">
                    <div class="col-xl-3">
                        <button class="btn btn-danger" data-delete-selected>Ištrinti pažymėtus</button>
                        <a href="/dashboard/events/create" class="btn btn-success">Sukurti naują užsiėmimą</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        $("[data-select-all]").click(function() {
            var checked = $(this).is(":checked");
            if(checked){
                $("[data-select]").prop("checked",true);
            }else{
                $("[data-select]").prop("checked",false);
            }
        });
        $("[data-delete-selected]").click(function () {
            if(!confirm("Ar tikrai norite ištrinti pažymėtus elementus?"))
                return;
            var button = $(this);
            var buttonText = $(this).html();
            var allCount = $("[data-select]:checked").length;
            var currentCount = 0;
            button.addClass("btn-disabled").html("Trinama... (0/"+allCount+")")
            $("[data-select]:checked").each(function () {
                var tr = $(this).parent().parent();
                var form = tr.find("[data-delete]");
                var formData = form.serialize();
                $.post(form.attr("action"), formData, function(data) {
                    currentCount++;
                    button.html("Trinama... ("+currentCount+"/"+allCount+")");
                    if(currentCount == allCount) {
                        alert("Pažymėti elementai sėkmingai ištrinti.");
                        button.html(buttonText).removeClass("btn-disabled");
                        window.location = window.location.href;
                    }
                });
            });
        });
    </script>
    <script>

        $('.filter').on('keyup change', function() {
            //clear global search values
            table.search('');
            table.column($(this).data('columnIndex')).search(this.value).draw();
        });

        var table = $('#dataTable').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            aoColumnDefs: [
                {
                    bSearchable: true,
                    bVisible: false,
                },
            ],
            columnDefs : [
                { targets: [0,6], sortable: false},
            ],
            order: [[2, "desc"]],
            responsive: true,
            sDom: "rtipl",
        } );
    </script>
    </div>
</x-user>

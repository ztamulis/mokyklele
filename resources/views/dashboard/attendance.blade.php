<x-app-layout>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-dark mb-1">Lankomumas ({{ $startDate->translatedFormat("Y F") }})</h3>
                    <div>
                        <a href="/dashboard/attendance/?date={{ $startDate->subDays(5)->startOfMonth()->format("Y-m-d") }}" class="btn btn-primary">< Praeitas mėn.</a>
                        <a href="/dashboard/attendance/?date={{ $startDate->addMonths(2)->startOfMonth()->format("Y-m-d") }}" class="btn btn-primary">Kitas mėn. ></a>
                        <select class="form-control" data-group-filter style="display: inline-block;width: 350px;">
                            <option value="-1">Pasirinkite grupę</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">#g{{ $group->id }} {{ $group->name }} ∙ {{ $group->display_name }} ∙ {{ $group->adminTime->format("H:i") }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                @for($i = 0; $i < $daysInMonth; $i++)
                                    <th>{{ $i + 1 }}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student => $dates)
                            <tr data-group="{{ explode("|",$student)[1] }}">
                                <td>{{ explode("|",$student)[0] }}</td>
                                @for($i = 0; $i < $daysInMonth; $i++)
                                    <td>
                                        @if(in_array(($i + 1), $dates))
                                            <i class="fa fa-check"></i>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                @for($i = 0; $i < $daysInMonth; $i++)
                                    <th>{{ $i + 1 }}</th>
                                @endfor
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("[data-group-filter]").change(function () {
           let groupId = $(this).val();

           $("table tbody tr").hide();

           if(groupId == "-1"){
               $("table tbody tr").show();
               return;
           }

           $("table tbody tr[data-group="+groupId+"]").show();
        });
    </script>
</x-app-layout>
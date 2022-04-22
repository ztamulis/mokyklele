<x-app-layout>
{{--    @php \App\Http\Controllers\GroupController::fixPaidGroupsTime(); @endphp--}}

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
    <h3 class="text-dark mb-4">Grupės</h3>
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="form-row">
                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="search" placeholder="Grupė" value="{{ request()->input("search") }}"></div>
                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="id" placeholder="ID" value="{{ request()->input("id") }}"></div>
                    <div class="col-xl-3">
                        <button class="btn btn-success" type="submit">Paieška</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                    <tr>
                        <th class="no-sort"><input type="checkbox" data-select-all></th>
                        <th></th>
                        <th>ID</th>
                        <th>Grupė</th>
                        <th>Trump. aprašymas</th>
                        <th>Priskirtų mokinių</th>
                        <th>Kaina</th>
                        <th>Laikas ({{ \App\TimeZoneUtils::currentGmtModifierText() }})</th>
                        <th>Laikas 2 ({{ \App\TimeZoneUtils::currentGmtModifierText() }})</th>
                        <th>Pradžios ({{ \App\TimeZoneUtils::currentGmtModifierText() }})</th>
                        <th>Pabaigos 2 ({{ \App\TimeZoneUtils::currentGmtModifierText() }})</th>
                        <th>Rodoma</th>
                        <th>Mokama</th>
                        <th>Skirta</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groups as $group)
                        <tr>
                            <td><input type="checkbox" data-select value="{{ $group->id }}"></td>
                            <td><div class="group--color group--{{ $group->type }}"></div></td>
                            <td>#g{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->display_name }}</td>
                            <td>{{ $group->students()->count() }} / {{ $group->slots }}</td>
                            <td>£{{ $group->price }}</td>
                            <td>{{ !empty($group->time) ? \App\TimeZoneUtils::updateTime(Carbon\Carbon::parse(Carbon\Carbon::parse($group->updated_at)->format('Y-m-d').$group->time->format('H:i'))->timezone('Europe/London'), $group->updated_at)->format('H:i') : "" }}</td>
                            <td>{{ !empty($group->time_2) ? \App\TimeZoneUtils::updateTime(Carbon\Carbon::parse(Carbon\Carbon::parse($group->updated_at)->format('Y-m-d ').$group->time_2->format('H:i'))->timezone('Europe/London'), $group->updated_at)->format('H:i') : "" }}</td>
                            <td>{{ $group->start_date ? \App\TimeZoneUtils::updateTime(Carbon\Carbon::parse($group->start_date)->timezone('Europe/London'), $group->updated_at)->format('Y-m-d H:i') : "00:00" }}</td>
                            <td>{{ $group->end_date ? \App\TimeZoneUtils::updateTime(Carbon\Carbon::parse($group->end_date)->timezone('Europe/London'), $group->updated_at)->format('Y-m-d H:i') : "00:00" }}</td>
                            <td>{{ $group->hidden ? "Ne" : "Taip" }}</td>
                            <td>{{ $group->paid ? "Taip" : "Ne" }}</td>
                            <td>{{ App\Models\Group::$FOR_TRANSLATE[$group->age_category]}}</td>

                            <td class="text-right">
                                <a href="/dashboard/groups/{{ $group->slug }}" class="btn btn-primary" type="button" style="margin: 0px 4px 0px;">Įeiti</a>
                                <a href="/dashboard/groups/{{ $group->slug }}/edit" class="btn btn-info" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                                <form action="/dashboard/groups/{{ $group->slug }}" data-delete method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti grupę?')" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Ištrinti</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xl-3">
                    <button class="btn btn-danger" data-delete-selected type="button">Ištrinti pažymėtus</button>
                    <a href="/dashboard/groups/create" class="btn btn-success" type="button">Sukurti naują grupę</a>
                </div>
                <div class="col-md-6 offset-xl-3">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        {{ $groups->links('components.pagination') }}
                    </nav>
                </div>
            </div>
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
</x-app-layout>


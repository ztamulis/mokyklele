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
        @php
            $user = \App\Models\User::find(request()->input("user_id"));
        @endphp

    <h3 class="text-dark mb-4">Mokiniai @if($user) (tėvas {{$user->fullName()}}) @endif</h3>
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="form-row">
                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="search" placeholder="Ieškoti" value="{{ request()->input("search") }}"></div>
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
                        <th>ID</th>
                        <th>Vardas, pavardė</th>
                        <th>Grupė</th>
                        <th>Tėvas</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td><input type="checkbox" data-select value="{{ $student->id }}"></td>
                            <td>#s{{$student->id}}</td>
                            <td>{{ $student->name }}</td>
                            <td>
                                @if($student->group)
                                    <div class="color--small background--{{ $student->group->type }}"></div> {{ $student->group->name }}
                                @else
                                    ?
                                @endif
                            </td>
                            <td>@if($student->user) {{ $student->user->name }} {{ $student->user->surname }} ({{ $student->user->email }}) @else ? @endif</td>
                            <td class="text-right">
                                <a href="/dashboard/students/{{ $student->id }}/edit?user_id={{ request()->input("user_id") }}" class="btn btn-info" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                                <form action="/dashboard/students/{{ $student->id }}?user_id={{ request()->input("user_id") }}" method="POST" data-delete onsubmit="return confirm('Ar tikrai norite ištrinti naudotoją?')" style="display: inline-block;">
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
                    <a href="/dashboard/students/create?user_id={{ request()->input("user_id") }}" class="btn btn-success" type="button">Pridėti naują</a>
                </div>
                <div class="col-md-6 offset-xl-3">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        {{ $students->links('components.pagination') }}
                    </nav>
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
    </div>
</x-app-layout>

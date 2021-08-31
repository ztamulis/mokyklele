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
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-dark mb-1">Rašyti žinutę</h3>
                                    <form method="POST" action="/dashboard/announcements/message" onsubmit="putRows()">
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="form-control summernote" name="text"></textarea>
                                        </div>
                                        <div class="form-group text-left">
                                            <div class="form-row">
                                                <div class="col">
                                                    <input class="form-control" type="text" name="search" id="search" placeholder="Ieškoti...">
                                                </div>
                                                <div class="col">
                                                    <select class="form-control" id="roleFilter">
                                                        <option value="showall" selected="">Rodyti visus</option>
                                                        <option value="Narys">Narys</option>
                                                        <option value="Mokytojas">Mokytojai</option>
                                                        <option value="Administratorius">Administracija</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select class="form-control" id="groupFilter">
                                                        <option value="showall">Rodyti visus</option>
                                                        @foreach(\App\Models\Group::all() as $group)
                                                            <option value="{{$group->name}}">{{$group->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Vardas, Pavardė</th>
                                                                    <th>El. Paštas</th>
                                                                    <th>Rolė</th>
                                                                    <th>Šalis</th>
                                                                    <th>Registracijos data</th>
                                                                    <th>Grupė(-s)</th>
                                                                    <th>Vaikai</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="userTable">
                                                            @foreach($users as $user)
                                                                <tr>
                                                                    <td>{{ $user->fullName() }}</td>
                                                                    <td>{{ $user->email }}</td>
                                                                    <td>{{ $user->roleText() }}</td>
                                                                    <td>{{ $user->country }}</td>
                                                                    <td>{{ $user->created_at }}</td>
                                                                    <td>
                                                                        @foreach($user->getGroups() as $group)
                                                                            {{ $group->name }}
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($user->students as $student)
                                                                            {{ $student->name }}
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-xl-3 offset-xl-9">
                                                    <div id="pagination"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-xl-3 offset-xl-9 text-right">
                                                    <button class="btn btn-success text-center" type="submit">Siųsti pažymėtams</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $("#search").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#userTable tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });
                            });
                            $("#roleFilter").change( function(){
                                $("#search").val("");
                                var value = $(this).val().toLowerCase();
                                if(value == "showall") {
                                    $('tr').show();
                                }else {
                                    $("#userTable tr").filter(function () {
                                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                }
                            });
                            $("#groupFilter").change( function(){
                                $("#search").val("");
                                var value = $(this).val().toLowerCase();
                                if(value == "showall") {
                                    $('tr').show();
                                }else {
                                    $("#userTable tr").filter(function () {
                                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                }
                            });
                            /*
                                PAGINATION
                             */
                            window.rows = []
                            $('table tbody tr').each(function(i, row) {
                                return window.rows.push(row);
                            });

                             $('#pagination').pagination({
                                dataSource: window.rows,
                                pageSize: 15,
                                autoHidePrevious: true,
                                autoHideNext: true,
                                showGoInput: true,
                                showGoButton: true,
                                callback: function(data, pagination) {
                                    $('tbody').html(data);
                                }
                            })
                        });

                        function putRows(){
                            $.each(window.rows, function( i, row ) {
                                $('#userTable tr:last').after(row);
                            });
                        }
                    </script>
</x-app-layout>
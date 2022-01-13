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
                                    <h3 class="text-dark mb-1">Duomenų lentelė</h3>
                                    <form>
                                        <div class="form-group text-left">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Vardas, Pavardė</th>
                                                                    <th>El. Paštas</th>
                                                                    <th>ID</th>
                                                                    <th>Grupė(-s)</th>
                                                                    <th>Mokiniai</th>
                                                                    <th>Sutikimas su naujienlaiškiu</th>
                                                                    <th>Rolė</th>
                                                                    <th>Šalis</th>
                                                                    <th>Registracijos data</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($users as $user)
                                                                <tr>
                                                                    <td>{{ $user->fullName() }}</td>
                                                                    <td>{{ $user->email }}</td>
                                                                    <td>#u{{ $user->id }}</td>
                                                                    <td>
                                                                        @foreach($user->getGroups() as $group)
                                                                            <div class="color--small background--{{ $group->type }}"></div> <small>#g{{ $group->id }}</small> ∙ {{ $group->color() }} ∙ {{ $group->name }} ∙ {{ $group->display_name }} ∙ {{ $group->adminTime ? $group->adminTime->format("H:i") : "00:00" }}<br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach($user->students as $student)
                                                                            @if($student->group)
                                                                                <div class="color--small background--{{ $student->group->type }}"></div>
                                                                            @endif
                                                                            @if($student->photo)
                                                                                <div class="color--small" style="background-image: url('/uploads/students/{{ $student->photo }}');background-size:cover;"></div>
                                                                            @endif
                                                                            <small>#s{{ $student->id }}</small> ∙ {{ $student->name }}{{ $student->birthday ? " ∙ b-day: " . $student->birthday->format("Y-m-d") : "" }}
                                                                            @if($student->group)
                                                                                <small>#g{{ $student->group->id }}</small> ∙ {{ $student->group->color() }} ∙ {{ $student->group->name }} ∙ {{ $student->group->display_name }} ∙ {{ $student->group->adminTime ? $student->group->adminTime->format("H:i") : "00:00" }}
                                                                            @endif
                                                                            <br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>{{ ($user->newsletter == 1 ? "Sutinka" : "Nesutinka") }}</td>
                                                                    <td>{{ $user->roleText() }}</td>
                                                                    <td>{{ $user->country }}</td>
                                                                    <td>{{ $user->created_at }}</td>
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
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $('#dataTable thead tr').clone(true).appendTo( '#dataTable thead' );
                        $('#dataTable thead tr:eq(1) th').each( function (i) {
                            var title = $(this).text();
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
                            dom: 'Bfrtip',
                            orderCellsTop: true,
                            fixedHeader: true,
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                },
                            ]
                        } );
                    </script>
</x-app-layout>
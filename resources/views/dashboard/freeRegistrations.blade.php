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
                                    <h3 class="text-dark mb-1">Nemokamos formos įrašai</h3>
                                    <form>
                                        <div class="form-group text-left">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Vardas</th>
                                                                    <th>El. Paštas</th>
                                                                    <th>Vaiko vardas</th>
                                                                    <th>Vaiko amžius</th>
                                                                    <th>Šalis</th>
                                                                    <th>Komentaras</th>
                                                                    <th>Naujienlaiškis</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($freeRegistrations as $freeRegistration)
                                                                <tr>
                                                                    <td>{{ $freeRegistration->id }}</td>
                                                                    <td>{{ $freeRegistration->name }}</td>
                                                                    <td>{{ $freeRegistration->email }}</td>
                                                                    <td>{{ $freeRegistration->student_name }}</td>
                                                                    <td>{{ $freeRegistration->student_age }}</td>
                                                                    <td>{{ $freeRegistration->country }}</td>
                                                                    <td>{{ $freeRegistration->comment }}</td>
                                                                    <td>{{ $freeRegistration->newsletter }}</td>
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
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
                    {{--<div class="row" style="margin: 0px -12px 6px;">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-dark mb-1">Rašyti naujienlaiškį</h3>
                                    <form method="POST" action="/dashboard/announcements/news">
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="form-control summernote" name="text"></textarea>
                                        </div>
                                        <div class="form-group text-right">
                                            <button class="btn btn-success" type="submit">Siųsti naujienlaiškį</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-dark mb-1">Rašyti žinutę</h3>
                                    <form method="POST" action="/dashboard/announcements/message" {{--onsubmit="putRows()"--}}>
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="form-control summernote" name="text"></textarea>
                                        </div>
                                        <div class="form-group text-left">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th class="no-sort"><input type="checkbox" data-select-all></th>
                                                                    <th>Vardas, Pavardė</th>
                                                                    <th>Rolė</th>
                                                                    <th>Grupė(-s)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="userTable">
                                                            @foreach($users as $user)
                                                                <tr data-filter="{{ $user->role }}">
                                                                    <td><input type="checkbox" name="check[]" class="caseCheck" data-select value="{{ $user->id }}"></td>
                                                                    <td>{{ $user->name }} {{ $user->surname }}</td>
                                                                    <td>{{ $user->roleText() }}</td>
                                                                    <td>@foreach($user->getGroups() as $group)
                                                                            <div class="color--small background--{{ $group->type }}"></div> {{ $group->name }} <small>({{ $group->time ? $group->time->format("H:i") : "00:00" }})</small><br>
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="form-row">
                                                <div class="col-xl-3 offset-xl-9">
                                                    <div id="pagination"></div>
                                                </div>
                                            </div>--}}
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
                        $("[data-select-all]").click(function() {
                            var checked = $(this).is(":checked");
                            if(checked){
                                $("[data-select]").prop("checked",true);
                            }else{
                                $("[data-select]").prop("checked",false);
                            }
                        });

                        $('#dataTable thead tr').clone(true).appendTo( '#dataTable thead' );
                        $('#dataTable thead tr:eq(1) th').each( function (i) {
                            if ($(this).index() === 0) {
                                $(this).html("");
                                return;
                            }
                            var title = $(this).text();
                            $(this).html('<input type="text" placeholder="Ieškoti ' + title + '" />');
                            $( 'input', this ).on( 'keyup change', function () {
                                if ( table.column(i).search() !== this.value ) {
                                    table
                                        .column(i)
                                        .search( this.value )
                                        .draw();
                                }
                            } );
                        } );

                        var table = $('#dataTable').DataTable( {
                            orderCellsTop: true,
                            fixedHeader: true,
                            columnDefs : [
                                { targets: 0, sortable: false},
                            ],
                        } );
                        /*$(document).ready(function(){
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
                            });*/
                            /*
                                PAGINATION
                             */
                            /*window.rows = []
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
                        }*/

                    </script>
</x-app-layout>
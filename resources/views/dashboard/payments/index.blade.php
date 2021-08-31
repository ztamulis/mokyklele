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
    <h3 class="text-dark mb-4">Vienkartiniai apmokėjimai</h3>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                @if(count($payments))
                    <table class="table my-0" id="dataTable1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stripe ID</th>
                                <th>Naudotojas</th>
                                <th>Laikas</th>
                                <th>Suma</th>
                                <th>Statusas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->payment_id }}</td>
                                    <td>{{ $payment->user ? $payment->user->email : "?" }}</td>
                                    <td>{{ $payment->created_at->format("Y-m-d H:i") }}</td>
                                    <td>
                                        {{ $payment->amount / 100 }}
                                    </td>
                                    <td>{{ $payment->payment_status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    Nėra apmokėjimų.
                @endif
            </div>
        </div>
    </div>
    <h3 class="text-dark mb-4 mt-4">Prenumeratos</h3>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                @if(count($subscriptions))
                    <table class="table my-0" id="dataTable2">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Stripe ID</th>
                            <th>Naudotojas</th>
                            <th>Vaikai</th>
                            <th>Laikas</th>
                            <th>Planas</th>
                            <th>Statusas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->id }}</td>
                                <td>{{ $subscription->stripe_id }}</td>
                                <td>{{ \App\Models\User::find($subscription->user_id) ? \App\Models\User::find($subscription->user_id)->email : "?" }}</td>
                                <td>
                                    @if($subscription->students)
                                        @foreach(json_decode($subscription->students) as $student_id)
                                            {{ \App\Models\Student::find($student_id) ? \App\Models\Student::find($student_id)->name : "?" }}<br>
                                        @endforeach
                                    @else
                                        ?
                                    @endif
                                </td>
                                <td>{{ $subscription->created_at->format("Y-m-d H:i") }}</td>
                                <td>
                                    {{ \App\Models\Group::where("stripe_plan", "LIKE", $subscription->stripe_plan)->count() ? \App\Models\Group::where("stripe_plan", "LIKE", $subscription->stripe_plan)->first()->name : $subscription->stripe_plan}}
                                </td>
                                <td>{{ $subscription->stripe_status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    Nėra prenumeratų.
                @endif
            </div>
        </div>
    </div>


        <script>

            $('#dataTable1 thead tr').clone(true).appendTo( '#dataTable1 thead' );
            $('#dataTable1 thead tr:eq(1) th').each( function (i) {
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

            var table1 = $('#dataTable1').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                order: [[0, "desc"]]
            } );

            $('#dataTable2 thead tr').clone(true).appendTo( '#dataTable2 thead' );
            $('#dataTable2 thead tr:eq(1) th').each( function (i) {
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

            var table1 = $('#dataTable2').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                order: [[0, "desc"]]
            } );

        </script>
</x-app-layout>

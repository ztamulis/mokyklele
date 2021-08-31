<x-app-layout>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-dark mb-1">Mokytojų vedamos pamokos ({{ $startDate->translatedFormat("Y F") }})</h3>
                    <div>
                        <a href="/dashboard/teacher-statistics/?date={{ $startDate->subDays(5)->startOfMonth()->format("Y-m-d") }}" class="btn btn-primary">< Praeitas mėn.</a>
                        <a href="/dashboard/teacher-statistics/?date={{ $startDate->addMonths(2)->startOfMonth()->format("Y-m-d") }}" class="btn btn-primary">Kitas mėn. ></a>
                    </div>
                    <i class="fa fa-check text-success"></i> - pamoka;
                    <i class="fa fa-check text-warning"></i> - individuali pamoka;
                    <i class="fa fa-check text-danger"></i> - nemokama pamoka;
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
                            @foreach($teachers as $teacher => $dates)
                            <tr>
                                <td>{{ $teacher }}
                                    <br>
                                    <small>
                                        <?php
                                            $lesson = 0; $individual = 0; $free = 0;
                                            foreach ($dates as $date) {
                                                if(explode("|", $date)[1] == "lesson"){
                                                    $lesson++;
                                                }elseif (explode("|", $date)[1] == "individual") {
                                                    $individual++;
                                                }else{
                                                    $free++;
                                                }
                                            }
                                        ?>
                                        {{ $lesson }} pamok., {{ $individual }} indiv. pamok., {{ $free }} nemok. pamok.
                                    </small>
                                </td>
                                @for($i = 0; $i < $daysInMonth; $i++)
                                    <td>
                                        @foreach($dates as $date)
                                            @if(explode("|", $date)[0] == $i + 1)
                                                <?php $lesson = explode("|", $date)[1]; ?>
                                                <i class="fa fa-check @if($lesson == 'lesson') text-success @elseif($lesson == 'individual') text-warning @else text-danger @endif "></i><br>
                                            @endif
                                        @endforeach
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
</x-app-layout>
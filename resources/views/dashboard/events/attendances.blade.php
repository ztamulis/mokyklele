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
    <h3 class="text-dark mb-4">Užsiėmimo lankomumas ({{ $event->name }})</h3>
    <div class="card"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/events/{{ $event->id }}/attendances" method="POST">
                        @csrf
                        @foreach($students as $student)
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-{{ $student->id }}" name="students[]" value="{{ $student->id }}" @if(\App\Models\Attendance::where("student_id", $student->id)->where("event_id",$event->id)->count()) checked @endif ><label class="form-check-label" for="formCheck-{{ $student->id }}">{{ $student->name }}</label></div>
                        @endforeach
                        <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti lankomumą</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
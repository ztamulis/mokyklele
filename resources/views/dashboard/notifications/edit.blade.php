<x-user>
    <div class="container--other">

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
    <h3 class="text-dark mb-4">Redaguoti laiškus</h3>
    <div class="card"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12">
                    <form action="{{route('reminders.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <p class="lh-1"><b>Kintamieji</b>: {grupe}; {grupes-savaites-diena}; {pamokos-laikas}; {vartotojo-laiko-juosta}; {susitikimo-diena-skaicius}; {susitikimo-valanda}; {susitikimo-menesis-kilmininkas} </p>
                            <p class="lh-1"><b>Kintamuosius būtina atskirti laužtiniais skliaustais {} ir negali būti rašomi lietuviškomis raidėmis. Tiksliai kaip nurodyta pasirinkimuose.</b></p>
                            <span class="form-text text-danger bold">Nemokama vaikų pamoka (geltona ir žalia)</span>
                            <textarea class="form-control summernote" name="free_lesson_yellow_and_green">{!! $notificationEmailContent->free_lesson_yellow_and_green !!}</textarea>
                        </div>
                        <small class="form-text text-muted">Susitikimas</small>
                        <select class="form-control" name="free_lesson_yellow_and_green_meeting_id" aria-label="Default select example">
                            <option {{old('free_lesson_yellow_and_green_meeting_id') || $notificationEmailContent->free_lesson_yellow_and_green_meeting_id === '' ? 'selected' : ''}} value="0">Jokio</option>
                            @foreach($meetings as $meeting)
                                <option {{old('free_lesson_yellow_and_green_meeting_id') || $meeting->id === $notificationEmailContent->free_lesson_yellow_and_green_meeting_id ? 'selected' : ''}} value="{{$meeting->id}}">
                                    {{$meeting->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-group"><small class="form-text text-muted">Laiško tema</small>
                            <input class="form-control" type="text" name="free_lesson_yellow_and_green_subject" value="{{ $notificationEmailContent->free_lesson_yellow_and_green_subject }}" >
                        </div>



                        <div class="form-group mt-5">
                            <p class="lh-1"><b>Kintamieji</b>: {grupe}; {grupes-savaites-diena}; {pamokos-laikas}; {vartotojo-laiko-juosta}; {susitikimo-diena-skaicius}; {susitikimo-valanda}; {susitikimo-menesis-kilmininkas} </p>
                            <p class="lh-1"><b>Kintamuosius būtina atskirti laužtiniais skliaustais {} ir negali būti rašomi lietuviškomis raidėmis. Tiksliai kaip nurodyta pasirinkimuose.</b></p>
                            <span class="form-text text-danger bold">Nemokama vaikų pamoka (mėlyna ir raudona)</span>
                            <textarea class="form-control summernote" name="free_lesson_red_and_blue">{!! $notificationEmailContent->free_lesson_red_and_blue !!}</textarea>
                        </div>
                        <small class="form-text text-muted">Susitikimas</small>
                        <select class="form-control" name="free_lesson_red_and_blue_meeting_id" aria-label="Default select example">
                            <option {{old('free_lesson_red_and_blue_meeting_id') || $notificationEmailContent->free_lesson_red_and_blue_meeting_id === '' ? 'selected' : ''}} value="0">Jokio</option>
                            @foreach($meetings as $meeting)
                                <option {{old('free_lesson_red_and_blue_meeting_id') || $meeting->id === $notificationEmailContent->free_lesson_red_and_blue_meeting_id ? 'selected' : ''}} value="{{$meeting->id}}">
                                    {{$meeting->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-group"><small class="form-text text-muted">Laiško tema</small>
                            <input class="form-control" type="text" name="free_lesson_red_and_blue_subject" value="{{ $notificationEmailContent->free_lesson_yellow_and_green_subject }}" >
                        </div>



                        <div class="form-group mt-5">
                            <p class="lh-1"><b>Kintamieji</b>: {pamokos-diena-angliskai}; {grupe}; {grupes-savaites-diena}; {pamokos-laikas}; {vartotojo-laiko-juosta}; </p>
                            <p class="lh-1"><b>Kintamuosius būtina atskirti laužtiniais skliaustais {} ir negali būti rašomi lietuviškomis raidėmis. Tiksliai kaip nurodyta pasirinkimuose.</b></p>
                            <span class="form-text text-danger bold">Nemokama suaugusiųjų pamoka</span>
                            <textarea class="form-control summernote" name="free_lesson_adults">{!! $notificationEmailContent->free_lesson_adults !!}</textarea>
                        </div>
                        <small class="form-text text-muted">Susitikimas</small>
                        <select class="form-control" name="free_lesson_adults_meeting_id" aria-label="Default select example">
                            <option {{old('free_lesson_adults_meeting_id') || $notificationEmailContent->free_lesson_adults_meeting_id === '' ? 'selected' : ''}} value="0">Jokio</option>
                            @foreach($meetings as $meeting)
                                <option {{old('free_lesson_adults_meeting_id') || $meeting->id === $notificationEmailContent->free_lesson_adults_meeting_id ? 'selected' : ''}} value="{{$meeting->id}}">
                                    {{$meeting->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-group"><small class="form-text text-muted">Laiško tema</small>
                            <input class="form-control" type="text" name="free_lesson_adults_subject" value="{{ $notificationEmailContent->free_lesson_adults_subject }}" >
                        </div>

                        <div class="form-group mt-5">
                            <p class="lh-1"><b>Kintamieji</b>: {pamokos-diena-angliskai}; {grupe}; {grupes-savaites-diena}; {pamokos-laikas}; {vartotojo-laiko-juosta}; </p>
                            <p class="lh-1"><b>Kintamuosius būtina atskirti laužtiniais skliaustais {} ir negali būti rašomi lietuviškomis raidėmis. Tiksliai kaip nurodyta pasirinkimuose.</b></p>
                            <span class="form-text text-danger bold">Mokama suaugusiųjų pamoka</span>
                            <textarea class="form-control summernote" name="paid_lesson_adults">{!! $notificationEmailContent->paid_lesson_adults !!}</textarea>
                        </div>
                        <small class="form-text text-muted">Susitikimas</small>
                        <select class="form-control" name="paid_lesson_adults_meeting_id" aria-label="Default select example">
                            <option {{old('paid_lesson_adults_meeting_id') || $notificationEmailContent->paid_lesson_adults_meeting_id === '' ? 'selected' : ''}} value="0">Jokio</option>
                            @foreach($meetings as $meeting)
                                <option {{old('paid_lesson_adults_meeting_id') || $meeting->id === $notificationEmailContent->paid_lesson_adults_meeting_id ? 'selected' : ''}} value="{{$meeting->id}}">
                                    {{$meeting->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-group"><small class="form-text text-muted">Laiško tema</small>
                            <input class="form-control" type="text" name="paid_lesson_adults_subject" value="{{ $notificationEmailContent->paid_lesson_adults_subject }}" >
                        </div>




                        <div class="form-group mt-5">
                            <p class="lh-1"><b>Kintamieji</b>: {grupe}; {grupes-savaites-diena}; {pamokos-laikas}; {vartotojo-laiko-juosta}; {susitikimo-diena-skaicius}; {susitikimo-valanda}; {susitikimo-menesis-kilmininkas}</p>
                            <p class="lh-1"><b>Kintamuosius būtina atskirti laužtiniais skliaustais {} ir negali būti rašomi lietuviškomis raidėmis. Tiksliai kaip nurodyta pasirinkimuose.</b></p>
                            <span class="form-text text-danger bold">Mokama pamoka (geltona ir žalia)</span>
                            <textarea class="form-control summernote" name="paid_lesson_yellow_and_green">{!! $notificationEmailContent->paid_lesson_yellow_and_green !!}</textarea>
                        </div>
                        <small class="form-text text-muted">Susitikimas</small>
                        <select class="form-control" name="paid_lesson_yellow_and_green_meeting_id" aria-label="Default select example">
                            <option {{old('paid_lesson_yellow_and_green_meeting_id') || $notificationEmailContent->paid_lesson_yellow_and_green_meeting_id === '' ? 'selected' : ''}} value="0">Jokio</option>
                            @foreach($meetings as $meeting)
                                <option {{old('paid_lesson_yellow_and_green_meeting_id') || $meeting->id === $notificationEmailContent->paid_lesson_yellow_and_green_meeting_id ? 'selected' : ''}} value="{{$meeting->id}}">
                                    {{$meeting->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-group"><small class="form-text text-muted">Laiško tema</small>
                            <input class="form-control" type="text" name="paid_lesson_yellow_and_green_subject" value="{{ $notificationEmailContent->free_lesson_yellow_and_green_subject }}" >
                        </div>




                        <div class="form-group mt-5">
                            <p class="lh-1"><b>Kintamieji</b>: {grupe}; {grupes-savaites-diena}; {pamokos-laikas}; {vartotojo-laiko-juosta}; {susitikimo-diena-skaicius}; {susitikimo-valanda}; {susitikimo-menesis-kilmininkas}; {grupe-kilmininko-linksnis} </p>
                            <p class="lh-1"><b>Kintamuosius būtina atskirti laužtiniais skliaustais {} ir negali būti rašomi lietuviškomis raidėmis. Tiksliai kaip nurodyta pasirinkimuose.</b></p>
                            <span class="form-text text-danger bold">Mokama pamoka (mėlyna ir raudona)</span>
                            <textarea class="form-control summernote" name="paid_lesson_red_and_blue">{!! $notificationEmailContent->paid_lesson_red_and_blue !!}</textarea>
                        </div>
                        <small class="form-text text-muted">Susitikimas</small>
                        <select class="form-control" name="paid_lesson_red_and_blue_meeting_id" aria-label="Default select example">
                            <option {{old('paid_lesson_red_and_blue_meeting_id') || $notificationEmailContent->paid_lesson_red_and_blue_meeting_id === '' ? 'selected' : ''}} value="0">Jokio</option>
                            @foreach($meetings as $meeting)
                                <option {{old('paid_lesson_red_and_blue_meeting_id') || $meeting->id === $notificationEmailContent->paid_lesson_red_and_blue_meeting_id ? 'selected' : ''}} value="{{$meeting->id}}">
                                    {{$meeting->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-group"><small class="form-text text-muted">Laiško tema</small>
                            <input class="form-control" type="text" name="paid_lesson_red_and_blue_subject" value="{{ $notificationEmailContent->free_lesson_yellow_and_green_subject }}" >
                        </div>



                        <div class="form-group mt-5"><button class="btn btn-primary" type="submit">Atnaujinti susitikimą</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-user>
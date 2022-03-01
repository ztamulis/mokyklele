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
        <h3 class="text-dark mb-4">Atnaujinti narį</h3>
        <div class="card"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <form action="{{route('pages.team-member.update', $teamMember->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <small class="form-text text-muted">Vardas pavarde</small>
                                <input class="form-control" type="text" name="full_name" placeholder="Vardenis pavardenis" value="{{ $teamMember->full_name }}">
                            </div>
                            <div class="form-group">
                                <small class="form-text text-muted">Aprašymas</small>
                                <textarea class="form-control summernote" name="description"> {!! $teamMember->description !!}</textarea>
                            </div>

                            <div class="custom-file">
                                <input name="img" type="file" class="custom-file-input" id="validatedCustomFile"  accept=".jpg,.jpeg,.png,.svg,.gif"/>
                                <label class="custom-file-label" for="validatedCustomFile">Pasirinkti nuotrauką...</label>
                            </div>

                            <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti narį</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user>
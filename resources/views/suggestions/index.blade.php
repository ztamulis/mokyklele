<x-user>
    <div class="container--other">
    @if(isset($message))
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
            </div>
        </div>
    @endif
    @if(Session::has('message'))
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert"><span>{{ Session::get('message') }}</span></div>
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

        <h3 class="text-dark mb-4">Puslapio informacija</h3>
        <div class="col-xl-3 mb-4"><a href="{{route('suggestions-config.edit')}}" class="btn btn-sm btn-dark text-white" type="button">Keisti patarimų puslapio duomenis</a></div>

        <h3 class="text-dark mb-4">Patarimai tėvams</h3>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                @if(count($suggestions))
                    <table class="table my-0" id="dataTable">
                        <thead>
                        <tr>
                            <th>Pavadinimas</th>
{{--                            <th>Aprašyas</th>--}}
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suggestions as $suggestion)
                            <tr>
                                <td>{{ $suggestion->title }}</td>
{{--                                <td>{!! $suggestion->description !!}</td>--}}
                                <td class="text-right">
                                    @if(Auth::user()->role == "admin")
                                        <a href="/dashboard/suggestions/{{ $suggestion->id }}/edit" class="btn btn-warning" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                                        <form action="/dashboard/suggestions/{{ $suggestion->id }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti susitikimą?')" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Ištrinti</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    Nėra sukurtų patarimų.
                @endif
            </div>
            <div class="row">
                <div class="col-xl-3"><a href="/dashboard/suggestions/create" class="btn btn-primary" type="button">Sukurti naują patarimą</a></div>
            </div>
        </div>
    </div>
    </div>

</x-user>

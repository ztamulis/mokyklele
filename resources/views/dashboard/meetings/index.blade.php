<x-app-layout>
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
    <h3 class="text-dark mb-4">Susitikimai</h3>
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="form-row">
                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="search" placeholder="Ieškoti" value="{{ request()->input("search") }}"></div>
                    <div class="col-xl-3">
                        <button class="btn btn-success" type="submit">Paieška</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                @if(count($meetings))
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Pavadinimas</th>
                                <th>Laikas ({{ \App\TimeZoneUtils::currentGmtModifierText() }})</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                                <tr>
                                    <td><div class="color--small background--blue" @if($meeting->photo) style="background-image: url('/uploads/meetings/{{ $meeting->photo }}')" @endif ></div></td>
                                    <td>{{ $meeting->name }}</td>
                                    <td>{{ $meeting->adminTime->format("Y-m-d H:i") }}</td>
                                    <td class="text-right">
                                        @if(Auth::user()->role == "admin")
                                            <a href="/dashboard/meetings/{{ $meeting->id }}/edit" class="btn btn-warning" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                                            <form action="/dashboard/meetings/{{ $meeting->id }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti susitikimą?')" style="display: inline-block;">
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
                    Nėra sukurtų susitikimų.
                @endif
            </div>
            <div class="row">
                <div class="col-xl-3"><a href="/dashboard/meetings/create" class="btn btn-success" type="button">Sukurti naują susitikimą</a></div>
                <div class="col-md-6 offset-xl-3">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        {{ $meetings->links('components.pagination') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

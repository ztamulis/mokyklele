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
    <h3 class="text-dark mb-4">Apdovanojimai</h3>
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
                @if(count($rewards))
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Pavadinimas</th>
                                <th>Aprašymas</th>
                                <th>Lankytų pamokų dėl apdovanojimo skaičius</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rewards as $reward)
                                <tr>
                                    <td><img src="/uploads/rewards/{{ $reward->file }}" style="height: 30px"></td>
                                    <td>{{ $reward->name }}</td>
                                    <td>{{ Str::limit(strip_tags($reward->description), 50) }}</td>
                                    <td>{{ $reward->attendance_to_get_reward >= 0 ? $reward->attendance_to_get_reward : "Šis apdovanojimas skirtas priskyrimui."}}</td>
                                    <td class="text-right">
                                        @if(Auth::user()->role == "admin")
                                            <a href="/dashboard/rewards/{{ $reward->id }}/edit" class="btn btn-warning" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                                            <form action="/dashboard/rewards/{{ $reward->id }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti apdovanojimą?')" style="display: inline-block;">
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
                    Nėra sukurtų apdovanojimų.
                @endif
            </div>
            <div class="row">
                <div class="col-xl-3">
                    @if(Auth::user()->role == "admin")
                        <a href="/dashboard/rewards/create" class="btn btn-success" type="button">Sukurti naują apdovanojimą</a>
                    @endif

                    <a href="/dashboard/users" class="btn btn-primary" type="button">Priskirti apdovanojimą</a>
                </div>
                <div class="col-md-6 offset-xl-3">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        {{ $rewards->links('components.pagination') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

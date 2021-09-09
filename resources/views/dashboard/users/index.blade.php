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
    <h3 class="text-dark mb-4">Vartotojai</h3>
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="form-row">
                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="search" placeholder="Ieškoti" value="{{ request()->input("search") }}"></div>
                    <div class="col-xl-3"><select class="form-control" data-filter-select name="role">
                            <option @if(request()->input("role") == "showall") selected @endif value="showall">Rodyti visus</option>
                            <option @if(request()->input("role") == "user") selected @endif value="user">Naudotojai</option>
                            <option @if(request()->input("role") == "teacher") selected @endif value="teacher">Mokytojai</option>
                            <option @if(request()->input("role") == "admin") selected @endif value="admin">Administratoriai</option>
                        </select></div>
                    <div class="col-xl-3">
                        <button class="btn btn-success" type="submit">Paieška</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Naudotojas</th>
                            <th>Vaikai</th>
                            <th>Apdovanojimai</th>
                            <th class="text-center">Veiksmai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr data-filter="{{ $user->role }}">
                                <td>#u{{ $user->id }}</td>
                                <td><b>{{ $user->name }} {{ $user->surname }}</b> ∙ {{ $user->roleText() }}<br>
                                    {{ $user->email }}
                                    @if($user->role == "teacher")
                                        (pravesta {{ \App\Models\Event::where("teacher_id", $user->id)->where("date_at", "<", \Carbon\Carbon::now())->count() }} pam.)
                                    @endif
                                </td>
                                <td>
                                    @foreach($user->students as $student)
                                        @if($student->group) <div class="color--small background--{{ $student->group->type }}"></div> @endif <b>{{ $student->name }}</b> ∙ {{ $student->group ? $student->group->name : "?" }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($user->rewards as $reward)
                                        <img src="/uploads/rewards/{{ $reward->file }}" style="height: 25px"> {{ $reward->name }}<br>
                                    @endforeach
                                </td>
                                <td class="{{Auth::user()->role === 'teacher' ? 'text-center' : 'text-right'}}">
                                    @if(Auth::user()->role === "admin")
                                    <a href="/dashboard/students/?user_id={{ $user->id }}" class="btn btn-success" style="margin: 0px 4px 0px;">Vaikai</a>
                                    @endif
                                    <a href="/dashboard/user-rewards/{{ $user->id }}" class="btn btn-warning" style="margin: 0px 4px 0px;">Apdovanojimai</a>
                                        @if(Auth::user()->role === "admin")
                                            <a href="/dashboard/users/{{ $user->id }}/edit" class="btn btn-info" style="margin: 0px 4px 0px;">Redaguoti</a>
                                            <form action="/dashboard/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti naudotoją?')" style="display: inline-block;">
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
            </div>
            @if(Auth::user()->role === "admin")
            <div class="row">
                <div class="col-md-9">
                    <a href="/dashboard/users/export" class="btn btn-success">Eksportuoti EXCEL formatu</a>
                    <a href="/dashboard/students" class="btn btn-secondary">Visi vaikai</a>
                    <a href="/dashboard/users/create" class="btn btn-primary">Sukurti naują</a>
                </div>
                <div class="col-md-3">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        {{ $users->links('components.pagination') }}
                    </nav>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

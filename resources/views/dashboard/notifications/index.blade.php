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
        <h3 class="text-dark mb-4">Automatiniai laiškai</h3>
        <div class="col-xl-3 mb-4"><a href="{{route('reminders.edit')}}" class="btn btn-dark text-white" type="button">Keisti automatinių laiškų turinį</a></div>


        <h3 class="text-dark mb-4">Automatinių laiškų sąrašas</h3>
    <div class="card">
        <div class="card-body">
{{--            <form method="GET">--}}
{{--                <div class="form-row">--}}
{{--                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="search" placeholder="Ieškoti" value="{{ request()->input("search") }}"></div>--}}
{{--                    <div class="col-xl-3">--}}
{{--                        <button class="btn btn-success" type="submit">Paieška</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                @if(count($notifications))
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>El.paštas</th>
                                <th>Tipas</th>
                                <th>Grupės id</th>
                                <th>Amžiaus grupė</th>
                                <th>Mokama</th>
                                <th class="w-50">Siuntimo laikas ({{ \App\TimeZoneUtils::currentGmtModifierText() }})</th>
                                <th>Išssiųsta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)

                                @php
                                        $group = $notification->group()->first();
                                        @endphp
                                <tr>
                                    <td>{{ $notification->email }}</td>
                                    <td>{{ $group->color() }}</td>
                                    <td>#{{ $group->id }}</td>
                                    <td>{{ $notification->age_category === 'children' ? 'Vaikai' : 'Suaugusieji' }}</td>
                                    <td>{{ $group->paid == 1 ? 'Taip' : 'Ne' }}</td>
                                    <td class="w-50">{{ \Carbon\Carbon::parse($notification->send_from_time)->timezone('Europe/London') }}</td>
                                    <td>{{ $notification->is_sent == 1 ? 'Taip' : 'Ne' }}</td>
                                    <td class="text-right">
                                        @if(Auth::user()->role == "admin")
{{--                                            <a href="/dashboard/introductions/{{ $notification->id }}/edit" class="btn btn-warning" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>--}}
                                            <form action="/dashboard/reminders/{{ $notification->id }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti susitikimą?')" style="display: inline-block;">
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
                <div class="col-xl-3"><a href="/dashboard/introductions/create" class="btn btn-success" type="button">Sukurti naują susitikimą</a></div>
                <div class="col-md-6 offset-xl-3">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        {{ $notifications->links('components.pagination') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-user>

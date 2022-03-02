<x-user>
    <div id="container--other" class="container--other">
        @if(isset($message))
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
                </div>
            </div>
        @endif
        @if(Session::has('message'))
            <div class="row text-center" id="flash-message" style="display: block;">
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
        <div class="col-xl-3 mb-4"><a href="{{route('pages.index')}}" class="btn btn-sm btn-dark text-white" type="button">Grįžti atgal</a></div>


        <h3 class="text-dark mb-4">Komanda</h3>
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
                    @if(count($teamMember))
                        <table  class="table my-0" id="dataTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Vardas pavarde</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            @foreach($teamMember as $member)
                                <tr >
                                    <td><div class="color--small background--blue" @if($member->img) style="background-image: url('/uploads/team_member/{{ $member->img }}')" @endif ></div></td>
                                    <td>{{ $member->full_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($member->date_at)->timezone('Europe/London') }}</td>
                                    <td><input type="hidden" name="id[]" value="{{$member->id}}"></td>
                                    <td class="text-right">
                                        @if(Auth::user()->role == "admin")
                                            <a href="{{route('pages.team-member.edit', $member->id)}}" class="btn btn-warning" type="button" style="margin: 0px 4px 0px;">Redaguoti</a>
                                            <form action="{{route('pages.team-member.destroy', $member->id)}}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti susitikimą?')" style="display: inline-block;">
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
                            <div class="col-xl-3"><button class="btn btn-success" onclick="getMessage()" type="button">Pakeisti tvarką</button></div>
                    @else
                        Nėra sukurtų susitikimų.
                    @endif

                </div>
                <div class="row">
                    <div class="col-xl-3"><a href="{{route('pages.team-member.create')}}" class="btn btn-success" type="button">Sukurti naują narį</a></div>
                    <div class="col-md-6 offset-xl-3">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            {{ $teamMember->links('components.pagination') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>$("#sortable").sortable();
        function getMessage() {
            var values = $("input[name='id[]']")
                .map(function(){return $(this).val();}).get();
            $.ajax({
                type:'POST',
                url: '{{route('pages.team-member.sort')}}',
                processData: true,
                data: {_token : '<?php echo csrf_token() ?>',  ids: values},
                success:function() {
                    var main = $('.container--other');
                    main.prepend('<div id="ajax-message" class="row"> <div class="col-xl-8 offset-xl-2"><div class="alert alert-primary text-center" role="alert"><span>Sąrašas atnaujintas</span></div> </div> </div>');
                    window.scrollTo(0, 0);
                setTimeout(function(){
                        $('#ajax-message').remove();
                    }, 3000);
                }
            });
        }
    </script>
</x-user>

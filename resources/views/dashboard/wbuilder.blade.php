<x-app-layout>

    <button type="button" data-toggle="modal" data-target="#changePageNameModal" class="btn btn-primary" style="position: absolute;top: 15px;right: 300px;">Puslapių pavadinimų keitimas</button>
    <a href="/dashboard/navbar" class="btn btn-secondary" style="position: absolute;top: 15px;right: 550px;">Meniu juosta</a>

    <iframe src="editor" class="editor--iframe" title="Puslapio builderis"></iframe>

    <!-- Modal -->
    <div class="modal fade" id="changePageNameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
            <div class="modal-content">
                <form data-change-names>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Pakeisti puslapių pavadinimus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Senas pavadinimas</th>
                                <th>Naujas pavadinimas</th>
                                <th>Veiksmai</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                setlocale(LC_ALL,'lt_LT.UTF-8');
                                $htmlFiles = glob(resource_path('views/landing/')."*.blade.php");
                                ?>
                                @foreach ($htmlFiles as $file)
                                <?php
                                    $pathInfo = pathinfo(str_replace('/', '/a', $file));
                                    $fileName = str_replace("-", " ", str_replace("_", " ", str_replace(".blade", "",  str_replace(".Blade", "", mb_convert_case(substr($pathInfo['filename'],1), MB_CASE_TITLE, 'UTF-8')))));
                                ?>
                                <tr>
                                    <td>{{ $fileName }}</td>
                                    <td><input class="form-control" type="text" name="{{ substr($pathInfo['filename'], 1) }}"></td>
                                    <td><button type="button" class="btn btn-danger" data-page-delete="{{ $file }}">Ištrinti</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Atšaukti</button>
                        <button type="submit" class="btn btn-primary">Išsaugoti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $("[data-change-names]").submit(function(event){
            event.preventDefault();
            let formData = $(this).serialize();
            formData['_token'] = "{{ csrf_token() }}";
            $.post("/dashboard/wbuilder/change-names", formData, function (data) {
                data = JSON.parse(data);
                if(data.status == "success"){
                    alert("Pavadinimas (-ai) sėkmingai pakeistas (-i)");
                    window.location.reload();
                }else{
                    alert("Įvyko klaida bandant pakeisti pavadinimus");
                }
            })
        });
        $("[data-page-delete]").click(function() {
            if(!confirm("Ar tikrai norite ištrinti puslapį?"))
                return;
            $.post("/dashboard/wbuilder/page-delete", {_token: '{{ csrf_token() }}', page: $(this).attr("data-page-delete")}, function (data) {
                data = JSON.parse(data);
                if(data.status == "success"){
                    alert("Puslapis sėkmingai ištrintas");
                    window.location.reload();
                }else{
                    alert("Įvyko klaida bandant ištrinti puslapį");
                }
            })
        });
    </script>
</x-app-layout>
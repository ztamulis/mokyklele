<x-app-layout>
                    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">-->
                    <link rel="stylesheet" href="/css/bootstrap-iconpicker.min.css">
                    <h3 class="text-dark mb-1">Meniu juostos redagavimas</h3>
                    <div class="row">
                        <div class="col">
                            <ul id="editor" class="sortableLists list-group">
                            </ul>
                            <br><button type="button" id="listUpdate" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Update</button>
                        </div>
                        <div class="col">
                            <div class="card border-primary mb-3">
                                <div class="card-header bg-primary text-white">Edit item</div>
                                <div class="card-body">
                                    <form id="frmEdit" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="text">Text</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control item-menu" name="text" id="text" placeholder="Text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="href">URL</label>
                                            <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                                        </div>
                                        <div class="form-group">
                                            <label for="target">Target</label>
                                            <select name="target" id="target" class="form-control item-menu">
                                                <option value="_self">Self</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Tooltip</label>
                                            <input type="text" name="title" class="form-control item-menu" id="title" placeholder="Tooltip">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                                    <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $( document ).ready(function() {

                            var iconPickerOptions = {searchText: "Ieškoti", labelHeader: "{0}/{1}"};
                            var sortableListOptions = {
                                placeholderCss: {'background-color': "#cccccc"}
                            };
                            var editor = new MenuEditor('editor',
                                {
                                    listOptions: sortableListOptions,
                                    maxLevel: 2
                                });

                            function save(){
                                $.post("/dashboard/save-navbar", {
                                    json: editor.getString(),
                                    _token: "{{ csrf_token() }}"
                            },
                                function(data,status){});
                            }

                            editor.setData({!! \App\Models\Navbar::find(1)->json !!});

                            editor.setForm($('#frmEdit'));
                            editor.setUpdateButton($('#btnUpdate'));

                            $("#btnUpdate").click(function(){
                                editor.update();
                                save();
                            });
                            $("#listUpdate").click(function(){
                                alert("Menu juosta buvo atnaujinta.");
                                editor.update();
                                save();
                            });                            
                            $('#btnAdd').click(function(){
                                editor.add();
                                save();
                            });
                        });

                    </script>
</x-app-layout>
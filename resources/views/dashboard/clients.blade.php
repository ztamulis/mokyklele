<x-app-layout>
                    <h3 class="text-dark mb-4">Klientai</h3>
                    <div class="card shadow">
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="search" placeholder="Ieškoti"><select class="form-control">
                                            <option value="parents" selected="">Tėvai</option>
                                            <option value="kids">Vaikai</option>
                                        </select></div>
                                    <div class="col-xl-3"><select class="form-control">
                                            <option value="yellow" selected="">Geltona grupė</option>
                                        </select>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Dalyvavo nemokamoje pamokoje</label></div>
                                    </div>
                                    <div class="col-xl-5"><input class="form-control" type="number" name="age" min="1" max="20" step="1" placeholder="Amžius"><select class="form-control">
                                            <optgroup label="This is a group">
                                                <option value="12" selected="">This is item 1</option>
                                                <option value="13">This is item 2</option>
                                                <option value="14">This is item 3</option>
                                            </optgroup>
                                        </select></div>
                                </div>
                            </form>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Vardas, pavardė</th>
                                            <th>Grupė</th>
                                            <th>Tėvas</th>
                                            <th>Nemokama pamoka</th>
                                            <th>Amžius</th>
                                            <th>Gyv. Šalis</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Arnelis Kubilinskas</td>
                                            <td>Geltona grupė</td>
                                            <td>Nerijus Kapotis</td>
                                            <td>Dalyvavo</td>
                                            <td>11</td>
                                            <td>Anglija</td>
                                            <td class="text-right"><button class="btn btn-info" type="button" style="margin: 0px 4px 0px;">Redaguoti</button><button class="btn btn-danger" type="button">Ištrinti</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info" style="display: none;">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Vardas, pavardė</th>
                                            <th>Gyv. Šalis</th>
                                            <th>Naujienlaiškis</th>
                                            <th>Registracijos data</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Arnelis Kubilinskas</td>
                                            <td>Anglija</td>
                                            <td>Sutinka</td>
                                            <td>2021-01-13</td>
                                            <td class="text-right"><button class="btn btn-info" type="button" style="margin: 0px 4px 0px;">Redaguoti</button><button class="btn btn-danger" type="button">Ištrinti</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-xl-3"><button class="btn btn-success" type="button">Eksportuoti EXCEL formatu</button></div>
                                <div class="col-md-6 offset-xl-3">
                                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination">
                                            <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
</x-app-layout>
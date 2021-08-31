<x-app-layout>
                    <h3 class="text-dark mb-4">Vartotojai</h3>
                    <div class="card shadow">
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="col-md-6 col-xl-4 text-nowrap"><input class="form-control" type="text" name="search" placeholder="Ieškoti"></div>
                                    <div class="col-xl-3"><select class="form-control">
                                            <option value="showall" selected="">Rodyti visus</option>
                                            <option value="teachers">Mokytojai</option>
                                            <option value="admins">Administratoriai</option>
                                        </select></div>
                                </div>
                            </form>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Vardas, pavardė</th>
                                            <th>Rolė</th>
                                            <th>El. paštas</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mokytojas Antanas</td>
                                            <td>Mokytojas</td>
                                            <td>paštas@mokytojas.lt</td>
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
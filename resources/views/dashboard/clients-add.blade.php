<x-app-layout>
                    <h3 class="text-dark mb-4">Pridėti klientą</h3>
                    <div class="card shadow"></div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-8">
                                    <form>
                                        <div class="form-group"><small class="form-text text-muted">Prisijungimo vardas</small><input class="form-control" type="text" name="username" placeholder="vardas"></div>
                                        <div class="form-group"><small class="form-text text-muted">El. paštas</small><input class="form-control" type="email" name="email" placeholder="paštas@gmail.com"></div>
                                        <div class="form-group"><small class="form-text text-muted">Vardas</small><input class="form-control" type="text" name="first_name" placeholder="Vardenis"></div>
                                        <div class="form-group"><small class="form-text text-muted">Pavardė</small><input class="form-control" type="text" name="last_name" placeholder="Pavardenis"></div>
                                        <div class="form-group"><small class="form-text text-muted">Gyvenamoji šalis</small><select class="form-control">
                                                <optgroup label="This is a group">
                                                    <option value="12" selected="">This is item 1</option>
                                                    <option value="13">This is item 2</option>
                                                    <option value="14">This is item 3</option>
                                                </optgroup>
                                            </select></div>
                                        <div class="form-group"><small class="form-text text-muted">Slaptažodis</small><input class="form-control" type="password" name="password" placeholder="Slaptažodis"><button class="btn btn-success btn-sm" type="button" style="margin: 4px 0px 0px ;">Generuoti atsitiktini slaptažodį</button></div>
                                        <div class="form-group"><small class="form-text text-muted">Rolė</small><select class="form-control">
                                                <option value="client">Klientas</option>
                                                <option value="parent">Tėvas</option>
                                            </select></div>
                                        <div class="form-group"><button class="btn btn-primary" type="button">Pridėti naują klientą</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
</x-app-layout>
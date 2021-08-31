<x-app-layout>
                    @if(isset($message))
                        <div class="row">
                            <div class="col-xl-8 offset-xl-2">
                                <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
                            </div>
                        </div>
                    @endif
                    <h3 class="text-dark">{{$group->name}}</h3>
                    <div class="row">
                        <div class="col-xl-12 offset-xl-0">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <nav class="navbar navbar-light navbar-expand-md">
                                                <div class="container-fluid">
                                                    <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                                                    <div class="collapse navbar-collapse" id="navcol-1">
                                                        <ul class="nav navbar-nav">
                                                            <li class="nav-item"><a class="nav-link active" href="#">Pokalbiai</a></li>
                                                            <li class="nav-item"><a class="nav-link text-info" href="zoom">Prisijungti į pamoką</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="row" id="chat">
                                        <div class="col">
                                            <form method="POST" action="/dashboard/group/sendMessage">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <textarea class="form-control summernote" name="text"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-xl-2 offset-xl-10 text-right">
                                                        <div class="form-group">
                                                            <button class="btn btn-primary" type="submit">Paskelbti</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <hr />
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row">
                                                <div class="col-xl-12">

                                                    <div class="row" style="border-bottom-width: 1px;border-bottom-style: solid;margin: 0px -5px 14px;">
                                                        <div class="col-xl-2" style="border-right-width: 1px;border-right-style: solid;">
                                                            <h3 class="text-primary">Admin</h3>
                                                            <p>2021-01-11</p>
                                                        </div>
                                                        <div class="col align-self-center">
                                                            <p>Testinis pokalbis</p>
                                                        </div>
                                                    </div>

                                                    <div class="row" style="border-bottom-width: 1px;border-bottom-style: solid;margin: 0px -5px 14px;">
                                                        <div class="col-xl-2" style="border-right-width: 1px;border-right-style: solid;">
                                                            <h3 class="text-primary">Admin</h3>
                                                            <p>2021-01-11</p>
                                                        </div>
                                                        <div class="col align-self-center">
                                                            <p>Testinis pokalbis</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-3 offset-xl-9">
                                                    <div id="pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        /*
                            PAGINATION
                         */

                    </script>
</x-app-layout>
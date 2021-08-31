<x-app-layout>
                    <h3 class="text-dark mb-1">Žinutės</h3>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    @foreach(\App\Http\Controllers\MessageController::messages() as $message)
                                        <div class="row" style="margin: 0px 0px 20px;border-bottom-width: 1px;border-bottom-style: solid;">
                                            <div class="col-xl-3 text-center" style="border-right-width: 1px;border-right-style: solid;">
                                                <h2 class="text-dark">{{$message->author->name}}</h2><strong>{{$message->author->roleText()}}</strong><span class="text-monospace text-black-50" style="margin: 0px 0px 0px 8px;">{{$message->created_at->format("Y-m-d")}}</span>
                                            </div>
                                            <div class="col align-self-center">
                                                <p class="text-dark">{{$message->message}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-xl-3 offset-xl-9">
                                            <nav>
                                                <ul class="pagination">
                                                    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                                    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</x-app-layout>
<x-app-layout>
    @if(isset($message))
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert"><span>{{ $message }}</span></div>
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
    <h3 class="text-dark mb-4">Naudotojo apdovanojimai ({{ $user->name }} {{ $user->surname }})</h3>
    <div class="card"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/user-rewards/{{ $user->id }}" method="POST">
                        @csrf
                        @foreach(\App\Models\Reward::all() as $reward)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="formCheck-{{ $reward->id }}" name="rewards[]" value="{{ $reward->id }}" @if($user->rewards->contains($reward->id)) checked @endif >
                                <label class="form-check-label" for="formCheck-{{ $reward->id }}"><img src="/uploads/rewards/{{ $reward->file }}" style="height: 25px"> {{ $reward->name }}</label>
                            </div>
                        @endforeach
                        <br>
                        <div class="form-group"><button class="btn btn-primary" type="submit">Išsaugoti apdovanojimus</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
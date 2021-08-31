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
    <h3 class="text-dark mb-4">Atnaujinti mokinį</h3>
    <div class="card shadow"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    <form action="/dashboard/students/{{ $student->id }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="form-group"><small class="form-text text-muted">Vardas, pavardė</small><input class="form-control" type="text" name="name" placeholder="Vardenis" value="{{ $student->name }}"></div>
                        <div class="form-group"><small class="form-text text-muted">Grupė</small>
                            <select class="form-control" name="group_id" required>
                                <option value="-1">Nepriskirta</option>
                                @foreach($groups as $group)
                                    <option @if($group->id == $student->group_id) selected @endif value="{{ $group->id }}">#g{{ $group->id }} {{ $group->name }} ∙ {{ $group->display_name }} ∙ {{ $group->adminTime->format("H:i") }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><small class="form-text text-muted">Tėvas</small>
                            <select class="form-control" name="user_id" required>
                                <option value="-1">Nepriskirta</option>
                                @foreach($users as $user)
                                    <option @if($user->id == $student->user_id) selected @endif value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Gimimo data</small>
                            <input class="form-control" type="date" name="birthday" placeholder="{{ date("Y-m-d") }}" value="{{ $student->birthday ? $student->birthday->format("Y-m-d") : "" }}">
                        </div>
                        <div class="form-group"><button class="btn btn-primary" type="submit">Atnaujinti mokinį</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
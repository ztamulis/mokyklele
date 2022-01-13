<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Vardas</th>
        <th>Pavardė</th>
        <th>El. paštas</th>
        <th>Šalis</th>
        <th>Sutikimas su taisyklėmis</th>
        <th>Sutikimas su naujienlaiškiu</th>
        <th>Rolė</th>
        <th>Registracijos data</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->surname }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->country }}</td>
            <td>{{ $user->terms }}</td>
            <td>{{ $user->newsletter }}</td>
            <td>{{ $user->roleText() }}</td>
            <td>{{ $user->created_at->format("Y-m-d H:i:s") }}</td>
        </tr>
        @if($user->students()->count())
            <tr>
                <td></td>
                <td><b>{{ $user->name }} {{ $user->surname }} mokiniai:</b></td>
            </tr>
            @foreach($user->students as $student)
                <tr>
                    <td></td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->group ? $student->group->name : "" }}</td>
                    <td>{{ $student->group ? $student->group->created_at->format("Y-m-d H:i:s") : "" }}</td>
                </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>
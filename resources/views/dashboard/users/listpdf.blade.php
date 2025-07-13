<!DOCTYPE html>
<html>
<head>
    <title>Listado de Usuarios</title>
    <x-style-report/>
</head>
<body>
    <x-header-report/>
    <h2>
        LISTADO DE USUARIOS
    </h2>
    @foreach ($users->chunk(10) as $chunk)
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Email</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chunk as $user)
                <tr>
                    <td>{{ $user->name .' ' .$user->lastname}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
    <x-footer-report/>
</body>
</html>

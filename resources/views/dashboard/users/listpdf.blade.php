<!DOCTYPE html>
<html>
<head>
    <title>Listado de Usuarios</title>
    <style>
      body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #19993f; /* Indigo-600 */
            color: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .logo{
            width: 50px;
            height: 50px;
        }
        .nombre{
            width: 150px;
            height: 50px;
        }
    </style>
</head>
<body>
    <div>
        <img class="logo" src="{{ public_path('img/logos/logo.jpeg') }}" alt="">
        <img class="nombre" src="{{ public_path('img/logos/logo_nombre.jpeg') }}" alt="">
    </div>
    <h2>
        LISTADO DE USUARIOS
    </h2>
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name .' ' .$user->lastname}}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Representantes</title>
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
        LISTADO DE VISITADORES CON SUS ZONAS
    </h2>
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombres</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Estado</th>
                <th>Zonas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visitors as $visitor)
                <tr>
                    <td>{{ $visitor->code}}</td>
                    <td>{{ $visitor->name }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td>{{ $visitor->phone }}</td>
                    <td>{{ $visitor->active }}</td>
                    <td>
                        @foreach ($visitor->zone as $zona)
                                {{ $zona->code}}
                                {{ $zona->name}}<br>   
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

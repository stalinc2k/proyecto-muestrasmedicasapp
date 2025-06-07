<!DOCTYPE html>
<html>
<head>
    <title>Listado de Empresas</title>
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
        LISTADO DE EMPRESAS
    </h2>
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Razon Soocial</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $company->code}}
                        {{ $company->ruc}}
                    </td>
                    <td>{{ $company->name}}</td>
                    <td>{{ $company->address}}</td>
                    <td>{{ $company->phone}}</td>
                    <td>
                        @if ($company->type == 'supplier')
                            Proveedor
                        @else
                            Empresa Principal
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

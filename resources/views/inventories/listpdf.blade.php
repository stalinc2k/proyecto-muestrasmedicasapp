<!DOCTYPE html>
<html>
<head>
    <title>Kardex</title>
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
        LISTADO DE ZONA CON SUS REPRESENTANTES
    </h2>
    <table>
        <thead>
            <tr>
                <th>FECHA</th>
                <th>NUM MOVIMIENTO</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $inventory)
                <tr>
                    <div class="text-base font-semibold">
                        {{$inventory->dateinventory}}
                        <div class="font-normal text-gray-500">
                            {{$inventory->income_id ? 'Entrada': 'Salida'}}
                        </div>
                    </div>
                    <td class="px-6 py-4">
                    {{$inventory->income_id ?? $inventory->expense_id}}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-normal text-gray-500">
                            {{$inventory->product->code}}
                        </div>
                        {{$inventory->product->description}}
                    </td>
                    <td class="px-6 py-4">
                        {{$inventory->cantinventory}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

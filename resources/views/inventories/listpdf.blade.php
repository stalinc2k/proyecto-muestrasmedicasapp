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
            background-color: #11662a;
            /* Indigo-600 */
            color: white;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .nombre {
            width: 150px;
            height: 50px;
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 50px;
            color: #11662a;
            text-align: center;
            /* Centrar el texto */
        }

        #info {
            width: 20px;
            padding: 1px;
            border-style: none;
        }

        #info th,
        #info td {
            border: none;
        }

        #info th {
            text-align: right;
        }
        .page-break {
        page-break-after: always;
    }
    </style>
</head>
<body>
    <div>
        <img class="logo" src="{{ public_path('img/logos/logo.jpeg') }}" alt="">
        <img class="nombre" src="{{ public_path('img/logos/logo_nombre.jpeg') }}" alt="">
        <div>
            @php
                use Illuminate\Support\Carbon;
                use Illuminate\Support\Facades\Auth;
                $fechaActual = now();
                $hora = $fechaActual->toTimeString();
                $fecha = $fechaActual->toDateString();
                $anio = now()->year;
                $user = Auth::user();
            @endphp

            <table id="info">
                <tr>
                    <th>FECHA:</th>
                    <td>{{ $fecha }}</td>
                </tr>
                <tr>
                    <th>HORA:</th>
                    <td>{{ $hora }}</td>
                </tr>
                <tr>
                    <th>USUARIO:</th>
                    <td> {{ $user->name }}</td>
                </tr>

            </table>
        </div>
    
    </div>
    <h2>
        LISTADO MOVIMIENTOS KARDEX
    </h2>
    @foreach ($inventories->chunk(10) as $chunk)
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
            @foreach ($chunk as $inventory)
                <tr>
                    <td>
                    <div class="text-base font-semibold">
                        {{$inventory->dateinventory}}
                        <div class="font-normal text-gray-500">
                            {{$inventory->income_id ? 'Entrada': 'Salida'}}
                        </div>
                    </div>
                    </td>
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
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
    <footer>
        <p>Copyright &copy; {{ $anio }}. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

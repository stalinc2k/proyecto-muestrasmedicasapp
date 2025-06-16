<!DOCTYPE html>
<html>
<head>
    <title>Impresión Documento</title>
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
    <div >
        <h2 >Impresión del Egreso</h2>
        <hr >
        <table>
            <thead>
                <tr>
                    <th>Egreso Num.</th>
                    <th>Fecha.</th>
                    <th>Representante</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{$expense->id}}
                    </td>
                    <td>
                        {{$expense->deliverydate}}
                    </td>
                    <td>
                        {{$expense->visitor->name}}
                    </td>                    
                </tr>
            </tbody>
        </table>
        <h2>Detalle de Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Lote</th>
                    <th>Elaboración</th>
                    <th>Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expense->inventory as $inventory)
                <tr>
                    <td>
                        {{$inventory->cantinventory}}
                    </td>
                    <td>
                        {{$inventory->product->description}}
                    </td>                
                    <td>
                        {{$inventory->batch->code}}
                    </td>
                    <td>
                        {{$inventory->batch->initlot}}
                    </td>
                    <td>
                        {{$inventory->batch->finishlot}}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5">Total Unidades {{$inventory->expense->totalunits}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <footer>
        <p>Copyright &copy; {{ $anio }}. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
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
    <div >
        <h2 >Impresión del Ingreso</h2>
        <hr >
        <table>
            <thead>
                <tr>
                    <th>Ingreso Num.</th>
                    <th>Fecha.</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{$entry->id}}
                    </td>
                    <td>
                        {{$entry->entrydate}}
                    </td>
                    <td>
                        {{$entry->company_id}}
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
                @foreach ($entry->inventory as $inventory)
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
                    <td colspan="5">Total Unidades {{$inventory->income->totalunits}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
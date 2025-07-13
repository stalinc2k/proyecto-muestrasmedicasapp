<!DOCTYPE html>
<html>
<head>
    <title>Impresión Documento</title>
    <x-style-report/>
</head>
<body>
    
    <x-header-report/>
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
        @foreach ($expense->inventory->chunk(10) as $chunk)
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
                @foreach ($chunk as $inventory)
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
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
        @endforeach
    </div>
    <x-firmas-report/>
   <x-footer-report/>
</body>
</html>
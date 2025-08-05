<!DOCTYPE html>
<html>
<head>
    <title>Impresión Documento</title>
    <x-style-report/>
</head>
<body>
    <x-header-report/>
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
                        {{$entry->company->name}}
                    </td>                    
                </tr>
            </tbody>
        </table>
        <h2>Detalle de Productos</h2>
        @foreach ($entry->inventory->chunk(10) as $chunk)
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
                    <td colspan="5">Total Unidades {{$inventory->income->totalunits}}</td>
                </tr>
            </tbody>
        </table>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
        @endforeach
    </div>
    <hr>
    <x-firmas-report/>
   <x-footer-report/>
</body>
</html>
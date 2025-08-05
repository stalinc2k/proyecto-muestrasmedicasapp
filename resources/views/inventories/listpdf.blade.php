<!DOCTYPE html>
<html>
<head>
    <title>Kardex</title>
    <x-style-report/>
</head>
<body>
    <x-header-report/>
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
    <x-footer-report/>
    <x-firmas-report/>
</body>
</html>

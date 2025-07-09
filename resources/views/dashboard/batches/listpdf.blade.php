<!DOCTYPE html>
<html>
<head>
    <title>Listado de Lotes</title>
    <x-style-report/>
</head>
<body>
    <x-header-report/>
    <h2>
        LISTADO DE LOTES REGISTRADOS
    </h2>
    @foreach ($batches->chunk(15) as $chunk)
    <table>
        <thead>
            <tr>
                <th>CÓDIGO LOTE</th>
                <th>PRODUCTO</th>
                <th>PROVEEDOR</th>
                <th>F. ELAB.</th>
                <th>F. VENC.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chunk as $batch)
                <tr>
                    <td>
                        <div>
                        {{ $batch->code}}
                        </div>
                    </td>
                    <td>
                        <div>
                            {{$batch->product->description}}
                        </div>
                    </td>
                    <td>    
                        <div>
                            {{$batch->product->company->name}}
                        </div>    
                    </td>
                    <td>{{ $batch->initlot }}</td>
                    <td>{{ $batch->finishlot }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
    <x-footer-report/>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Productos</title>
    <x-style-report/>
</head>
<body>
    <x-header-report/>
    <h2>
        LISTADO DE PPRODUCTOS
    </h2>
    @foreach ($products->chunk(10) as $chunk)
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Proveedor</th>
                <th>Descripción</th>
                <th>Código de barras</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chunk as $product)
                <tr>
                    <td>{{ $product->code}}
                    </td>
                    <td>
                        {{ $product->company->name}}
                    </td>
                    <td>{{ $product->description}}</td>
                    <td>{{ $product->barcode??'0000000000'}}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{public_path($product->image)}}" class="logo" alt="">
                        @else
                            Sin Imagen
                        @endif
                        
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
</body>
</html>

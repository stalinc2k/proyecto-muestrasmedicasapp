<!DOCTYPE html>
<html>
<head>
    <title>Listado de Proveedores</title>
    <x-style-report/>
</head>
<body>
    <x-header-report/>
    <h2>
        LISTADO DE PROVEEDORES
    </h2>
    @foreach ($companies->chunk(10) as $chunk)
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Ruc</th>
                <th>Razon Soocial</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chunk as $company)
                <tr>
                    <td>
                        {{ $company->code}}
                    </td>
                    <td>
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
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
<x-footer-report/>
</body>
</html>

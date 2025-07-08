<!DOCTYPE html>
<html>

<head>
    <title>Listado de Zonas</title>
    <x-style-report/>
</head>

<body>
    <x-header-report/>
    <h2>
        LISTADO DE ZONA CON SUS REPRESENTANTES
    </h2>
    @foreach ($zones->chunk(10) as $chunk)
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Representante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chunk as $zone)
                    <tr>
                        <td>{{ $zone->code }}</td>
                        <td>{{ $zone->name }}</td>
                        <td>{{ $zone->visitor->name }}</td>
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

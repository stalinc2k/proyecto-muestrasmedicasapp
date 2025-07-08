<!DOCTYPE html>
<html>
<head>
    <title>Listado de Representantes</title>
  <x-style-report/>
</head>
<body>
    <x-header-report/>
    <h2>
        LISTADO DE VISITADORES CON SUS ZONAS
    </h2>
    @foreach ($visitors->chunk(10) as $chunk)
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombres</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Estado</th>
                <th>Zonas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chunk as $visitor)
                <tr>
                    <td>{{ $visitor->code}}</td>
                    <td>{{ $visitor->name }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td>{{ $visitor->phone }}</td>
                    <td>
                        @if ($visitor->active == 1)
                            ACTIVO
                        @else     
                            INACTIVO                       
                        @endif
                    </td>
                    <td>
                        @foreach ($visitor->zone as $zona)
                                {{ $zona->code}}
                                {{ $zona->name}}<br>   
                        @endforeach
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

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Representantes</title>
    <style>
        body {
              font-family: DejaVu Sans, sans-serif;
          }
  
          table {
              width: 100%;
              border-collapse: collapse;
          }
  
          thead {
              background-color: #11662a; /* Indigo-600 */
              color: white;
          }
  
          th, td {
              border: 1px solid #ccc;
              padding: 5px;
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
  
          footer {
          position: absolute;
          bottom: 0;
          width: 100%;
          height: 50px;
          color:#11662a;
          text-align: center; /* Centrar el texto */
      }
      #info{
          width: 20px;
          padding: 1px;
          border-style: none;
      }
  
      #info th,
          #info td {
              border: none;
          }
  
      #info th{
          text-align: right;
      }
      .page-break {
        page-break-after: always;
    }   
    </style>
</head>
<body>
    <div>
        <img class="logo" src="{{ public_path('img/logos/logo.jpeg') }}" alt="">
        <img class="nombre" src="{{ public_path('img/logos/logo_nombre.jpeg') }}" alt="">
    </div>
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
    <footer>
        <p>Copyright &copy; {{ $anio }}. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

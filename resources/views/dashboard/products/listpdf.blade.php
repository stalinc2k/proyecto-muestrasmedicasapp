<!DOCTYPE html>
<html>
<head>
    <title>Listado de Productos</title>
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
    </style>
</head>
<body>
    <div>
        <img class="logo" src="{{ public_path('img/logos/logo.jpeg') }}" alt="">
        <img class="nombre" src="{{ public_path('img/logos/logo_nombre.jpeg') }}" alt="">
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

    </div>
    <h2>
        LISTADO DE PPRODUCTOS
    </h2>
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
            @foreach ($products as $product)
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
    <footer>
        <p>Copyright &copy; {{ $anio }}. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

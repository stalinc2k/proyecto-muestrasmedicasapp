<div>
    <img class="logo w-full" src="{{ public_path('img/logos/Logo_principal.png') }}" alt="">
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
        <thead>
            <tr>
                <th>FECHA IMPRESIÓN</th>
                <th>HORA IMPRESIÓN</th>
                <th>USUARIO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $fecha }}</td>
                <td>{{ $hora }}</td>
                <td> {{ $user->name .' '. $user->lastname }}</td>
            </tr>
        </tbody>
    </table>
</div>
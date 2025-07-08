@php
            use Illuminate\Support\Carbon;
            use Illuminate\Support\Facades\Auth;
            $anio = now()->year;
            $user = Auth::user();
@endphp
<footer>
    <p>Copyright &copy; {{ $anio }}. Todos los derechos reservados.</p>
</footer>
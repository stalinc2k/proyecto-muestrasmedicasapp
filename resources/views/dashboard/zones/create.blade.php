@extends('dashboard.master')

@section('content')
    <form action="" method="POST">
        <div>
            <div>
                <label for="code">
                    Código Representante:
                    <input type="text" name="code" id="" minlength="0" maxlength="4">
                </label>
            </div>
            <div>
                <label for="name">
                    Nombre Representante:
                    <input type="text" name="name" id="" minlength="0" maxlength="50">
                </label>
            </div>
            <div>
                <label for="visitor_id">
                    Representante de Venta:
                    <select name="visitor_id" id="">
                        <option value="" selected></option>
                        <option value="">Visitador 1</option>
                        <option value="">Visitador 2</option>
                        <option value="">visitador 3</option>
                    </select>
                </label>
            </div>
        </div>
        <div>
            <button type="submit">
                Crear Zona
            </button>
        </div>
    </form>
@endsection
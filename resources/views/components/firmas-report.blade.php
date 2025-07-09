<div>
    <table id="pie_firmas">
        <thead>
            <tr>
                <th>Elaborado por:</th>
                <th>Aprobado Por:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <br>
                    <br>
                    <br>
                    <hr>
                    @auth
                        {{Auth()->user()->name .' '. Auth()->user()->lastname}}
                    @endauth
                </td>
                <td>
                    <br>
                    <br>
                    <br>
                    <hr>
                    GERENCIA
                </td>
            </tr>
        </tbody>
    </table>
</div>
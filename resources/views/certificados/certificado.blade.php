<!DOCTYPE html>
<html>
<head>
    <title>Certificado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 30px;
            margin-left: 50px;
            margin-right: 50px;
            margin-bottom: 40px;
        }
        p {
            text-align: justify;
            font-size: 15px;
            text-indent: -40px;
            padding-left: 40px;

        }
         .letra9 {
            text-align: right;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }

    </style>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td rowspan="4">
                    <img src="{{ public_path('images/logo.png') }}" style="width: 150px; padding: 5px"/>
                </td>
                <td><center>PARTICIPACIÓN E INCIDENCIA CIUDADANA</center></td>
                <td><div class="letra9">Código: PM-03-02-I1-F1</div></td>
            </tr>
            <tr>
                <td rowspan="3"><center><strong>CONSTANCIA DE EXISTENCIA DE PERSONERÍA JURÍDICA Y REPRESENTANTE LEGAL</strong></center></td>
                <td><div class="letra9">Versión:01</div></td>
            </tr>
            <tr>
                <td><div class="letra9">Fecha: 17/11/2022</div></td>
            </tr>
            <tr>
                <td><div class="letra9">Página 1 de 1</div></td>
            </tr>
        </tbody>
    </table>
    <center>
        <h3>EL SUBSECRETARIO DE PARTICIPACIÓN COMUNITARIA DE LA SECRETARÍA DE DESARROLLO SOCIAL</h3>

        <h3>HACE CONSTAR:</h3>
    </center>
    <p>Que, revisados los expedientes y las bases de datos que reposan en esta Dependencia, se pudo constatar que la <strong>JUNTA DE ACCIÓN COMUNAL</strong> de la <strong>JUNTA DE ACCIÓN COMUNAL DEL BARRIO {{ $certificado->nombre_junta }}</strong> de la {{ $certificado->comuna }}, del Municipio de San José de Cúcuta, Departamento Norte de Santander, cuenta con personería jurídica vigente otorgada mediante Resolución {{ $certificado->resolucion }} de {{ $certificado->fecha_resolucion }}</p>
    <p>Que,	el señor (a) <strong>{{ $certificado->nombre_dignatario }}</strong>, identificado (a) con la cédula de ciudadanía No. {{ $certificado->documento_dignario }}, es la actual REPRESENTANTE LEGAL de la precitada Junta de Acción Comunal, reconocida e inscrita por este Despacho mediante la elección realizada el {{ $certificado->fecha_eleccion }}</p>
    <p>Que, de conformidad con la ley 753 de 2002, el Decreto Municipal No. 0724 de 19 de julio de 2018, este Despacho ejerce Vigilancia, Inspección y Control sobre los organismos comunales de 1º y de 2º nivel existentes en el municipio.</p>
    @php
        use Carbon\Carbon;
        function numeroEnLetras($numero) {
            $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
            return $formatter->format($numero);
        }
        $fecha = Carbon::parse($certificado->created_at);
        $dia = $fecha->day;
        $diaEnLetras = numeroEnLetras($dia);
        $diaConCero = str_pad($dia, 2, '0', STR_PAD_LEFT);
        $mesNombre = $fecha->translatedFormat('F');
        $anio = $fecha->year;
    @endphp
    <p>Se expide la presente a los {{ $diaEnLetras }} ({{ $diaConCero }}) días del mes de {{ $mesNombre }} de {{ $anio }}.</p>
    <p>No. unico de certificado: <strong>{{ $certificado->codigo_hash }}</strong></p>
    <p></p>
    <br>
    <br>
    <p>_______________________________________<br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>Subsecretario de Participación Comunitaria
</body>
</html>

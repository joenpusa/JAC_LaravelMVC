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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 0px solid black;
        }
    </style>
</head>

<body>
    <br>
    <table>
        <tbody>
            <tr>
                <td>
                    <img src="{{ public_path('images/logo.png') }}" style="width: 150px; padding: 5px" />
                </td>
                <td style="width: 10%">

                </td>
                <td style="text-align: left">
                    <div class="letra_left">Certificado No. {{ $certificado->codigo_hash }}</div>
                </td>
            </tr>
        </tbody>
    </table>
    <br><br>
    <center>
        <h3>LA SECRETARIA DE DESARROLLO SOCIAL</h3>

        <h3>HACE CONSTAR:</h3>
    </center>
    <br>
    <p>
        Que el(la) señor(a) <strong>{{ $certificado->nombre_dignatario }}</strong>, identificado(a) con la cédula de
        ciudadanía No. <strong>{{ $certificado->documento_dignario }}</strong> esta registrado(a) como Representante de
        la {{ $certificado->tipo }} de Acción Cumunal <strong>{{ $certificado->nombre_junta }}</strong> de
        <strong>{{ $certificado->comuna }} de Norte de Santander</strong>, con
        personería:<strong>{{ $certificado->resolucion }}</strong>
    </p>
    @php
        use Carbon\Carbon;
        function numeroEnLetras($numero)
        {
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
    <p>Se expide la presente a los {{ $diaEnLetras }} ({{ $diaConCero }}) días del mes de {{ $mesNombre }} de
        {{ $anio }}.</p>
    <br>
    <br>
    <center>
        <img src="{{ public_path($config->keyfirma) }}" style="max-width: 220px; max-height: 120px;" />
        <h4>{{ $config->nombre_secretario }}</h4>
        <h4>{{ $config->secretaria }}</h4>
    </center>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <title>Certificado</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 100px;
            margin-bottom: 100px;
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: Arial, sans-serif;
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

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('imaReport/header.png') }}" style="width: 100%; height: 100%;">
    </div>

    <div class="footer">
        <img src="{{ public_path('imaReport/footer.png') }}" style="width: 100%; height: 100%;">
    </div>
    <div style="margin: 85px">
        <table>
            <tbody>
                <tr>
                    <td style="width: 60%">

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
            ciudadanía No. <strong>{{ $certificado->documento_dignario }}</strong> esta registrado(a) como Representante
            de
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
        <p>Se expide la presente a los {{ $diaEnLetras }} ({{ $diaConCero }}) días del mes de {{ $mesNombre }}
            de
            {{ $anio }}.</p>
        <br>
        <br>
        <center>
            <img src="{{ public_path($config->keyfirma) }}" style="max-width: 220px; max-height: 120px;" />
            <h4>{{ $config->nombre_secretario }}</h4>
            <h4>{{ $config->secretaria }}</h4>
        </center>
    </div>
</body>

</html>

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
            text-indent: 0px;
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
        <p style="text-align: justify; margin: 0px 40px; line-height: 2;">
            Que, la Junta de Acción Comunal <strong>{{ $certificado->nombre_junta ?? '________' }}</strong>, 
            del municipio de <strong>{{ $certificado->comuna ?? '________' }}</strong>, 
            Departamento Norte de Santander, identificada con la personería jurídica No. 
            <strong>{{ ($certificado->resolucion && $certificado->resolucion !== 'No Registra') ? $certificado->resolucion : '________' }}</strong>, 
            se encuentra inscrita y registrada en esta secretaría, su 
            <strong>{{ $certificado->cargo ?? 'PRESIDENTE' }}</strong> es 
            <strong>{{ $certificado->nombre_dignatario ?? '________' }}</strong> 
            identificado con cédula No. <strong>{{ $certificado->documento_dignario ?? '________' }}</strong> 
            reconocido mediante el auto No. <strong>{{ $certificado->auto_numero ?? '________' }}</strong> 
            para el periodo 01 de julio de 2026 al 30 de junio de 2030.
        </p>
        <br>
        <p style="text-align: justify; margin: 0px 40px; line-height: 2;">
            La anterior se expide a solicitud de interesado.
        </p>
        <br>
        <br>
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
        <p style="margin: 0px 40px;">Dada en San José de Cúcuta a los {{ $diaEnLetras }} ({{ $diaConCero }}) días del mes de {{ $mesNombre }} de {{ $anio }}.</p>
        <br>
        <br>
        <center>
            @if(isset($config) && $config->keyfirma)
                <img src="{{ public_path($config->keyfirma) }}"
                    style="max-width: 220px; max-height: 120px; margin-bottom: -20px;" />
            @endif
            <h4 style="margin: 0px;">{{ $config->nombre_secretario ?? 'Secretario(a) de Desarrollo Social' }}</h4>
            <h4 style="margin: 0px;">{{ $config->secretaria ?? 'Secretaría de Desarrollo Social' }}</h4>
        </center>
    </div>
</body>

</html>

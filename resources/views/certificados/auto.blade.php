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
            font-size: 11px;
        }

        p {
            text-align: justify;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
            font-family: Calibri, sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid black;
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
    @php
        use Carbon\Carbon;
        function numeroEnLetras($numero)
        {
            $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
            return $formatter->format($numero);
        }
        $fecha = Carbon::parse($auto->created_at);
        $dia = $fecha->day;
        $diaEnLetras = numeroEnLetras($dia);
        $diaConCero = str_pad($dia, 2, '0', STR_PAD_LEFT);
        $mesNombre = $fecha->translatedFormat('F');
        $anio = $fecha->year;
    @endphp
    <div style="margin: 85px">
        Auto N° {{ $auto->numero }}
        <center>
            Fecha {{ $diaConCero }} de {{ $mesNombre }} de {{ $anio }}
        </center>
        <p>
            El Secretario de Desarrollo Social de la Gobernación Norte de Santander en uso de sus atribuciones legales
            conferidas en el articulo 76 Numeral 5 de la ley 2166 de diciembre 18 de 2021 y demás comunales
        </p>
        <center>
            <strong>CONSIDERANDO</strong>
        </center>
        <p>
            Que la Junta de Acción Comunal <strong>{{ $owner->nombre }}</strong>, Municipio
            <strong>{{ $owner->municipio->nombre_municipio }}</strong>, Departamento Norte de Santander, con
            personeria jurídica No. <strong>{{ $owner->personeria }}</strong>, realizo asamblea con el fin de elegir
            parcialmente dignatarios para el periodo 1 de julio de 2024 al 30 de junio de 2026.
        </p>
        <p>
            Que, revisamdos los documentos requeridosse encontró con eñ lleno de los requisitos legales y que las
            deciciones tomadas fueron válidadas.
        </p>
        <center>
            <strong>RESUELVE</strong>
        </center>
        <p>Inscribir los dignatarios de la junta de Acción Comunal <strong>{{ $owner->nombre }}</strong>, Municipio
            <strong>{{ $owner->municipio->nombre_municipio }}</strong>, Departamento Norte de Santander. Para el
            periodo
            1 de julio de 2024 al 30 de junio de 2026.
        </p>
        <p><strong>DIRECTIVA</strong></p>
        <table border="1" style="width: 100%">
            <tr>
                <td style="width: 30%">
                    <strong>PRESIDENTE</strong>
                </td>
                <td style="width: 70%">
                    {{ $owner->presidente->nombre }}
                </td>
            </tr>
            <tr>
                <td style="width: 30%">
                    <strong>VICEPRESIDENTE</strong>
                </td>
                <td style="width: 70%">
                    {{ $owner->vicepresidente->nombre }}
                </td>
            </tr>
            <tr>
                <td style="width: 30%">
                    <strong>TESORERO</strong>
                </td>
                <td style="width: 70%">
                    {{ $owner->tesorero->nombre }}
                </td>
            </tr>
            <tr>
                <td style="width: 30%">
                    <strong>SECRETARIO</strong>
                </td>
                <td style="width: 70%">
                    {{ $owner->secretario->nombre }}
                </td>
            </tr>
            <tr>
                <td style="width: 30%">
                    <strong>FISCAL</strong>
                </td>
                <td style="width: 70%">
                    {{ $owner->fiscal->nombre }}
                </td>
            </tr>

        </table>
        <p><strong>DIRECTIVA</strong></p>
        <table border="1" style="width: 100%">
            @foreach ($owner->comisiones as $comision)
                <tr>
                    <td style="width: 30%">
                        <strong>{{ $comision->nomcomision }}</strong>
                    </td>
                    <td style="width: 70%">
                        {{ $comision->nomcomisionado }}
                    </td>
                </tr>
            @endforeach

        </table>
        <p>
            <strong>COMUNÍQUESE Y CÚMPLASE</strong>
            <br>
            Dado en San José de Cúcuta,
        </p>
        <center>
            <img src="{{ public_path($config->keyfirma) }}" style="max-width: 220px; max-height: 120px;" />
            <h4>{{ $config->nombre_secretario }}<br>{{ $config->secretaria }}</h4>
        </center>
    </div>
</body>

</html>

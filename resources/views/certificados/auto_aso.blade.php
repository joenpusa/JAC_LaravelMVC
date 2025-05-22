<!DOCTYPE html>
<html>

<head>
    <title>Certificado</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 120px;
            margin-bottom: 120px;
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        p {
            text-align: justify;
            font-size: 12px;
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
        <H3>Auto N° {{ $auto->numero }}</H3>
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
            Que la Asociación de Acción Comunal <strong>{{ $owner->nombre }}</strong>, Municipio
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
        <p>Inscribir los dignatarios de la asociación de Acción Comunal <strong>{{ $owner->nombre }}</strong>, Municipio
            <strong>{{ $owner->municipio->nombre_municipio }}</strong>, Departamento Norte de Santander. Para el
            periodo 1 de julio de 2024 al 30 de junio de 2026.
        </p>
        <p><strong>DIRECTIVA</strong></p>
        <table border="1" style="width: 100%">
            <tr>
                <td style="width: 25%">
                    <strong>PRESIDENTE</strong>
                </td>
                <td style="width: 50%">
                    {{ $owner->presidente->nombre }}
                </td>
                <td style="width: 25%">
                    {{ $owner->presidente->num_documento }}
                </td>
            </tr>
            <tr>
                <td style="width: 25%">
                    <strong>VICEPRESIDENTE</strong>
                </td>
                <td style="width: 50%">
                    {{ $owner->vicepresidente->nombre }}
                </td>
                <td style="width: 25%">
                    {{ $owner->vicepresidente->num_documento }}
                </td>
            </tr>
            <tr>
                <td style="width: 25%">
                    <strong>TESORERO</strong>
                </td>
                <td style="width: 50%">
                    {{ $owner->tesorero->nombre }}
                </td>
                <td style="width: 25%">
                    {{ $owner->tesorero->num_documento }}
                </td>
            </tr>
            <tr>
                <td style="width: 25%">
                    <strong>SECRETARIO</strong>
                </td>
                <td style="width: 50%">
                    {{ $owner->secretario->nombre }}
                </td>
                <td style="width: 25%">
                    {{ $owner->secretario->num_documento }}
                </td>
            </tr>
        </table>
        <p></p>
        <table border="1" style="width: 100%">
            <tr>
                <td style="width: 25%">
                    <strong>FISCAL</strong>
                </td>
                <td style="width: 50%">
                    {{ $owner->fiscal->nombre }}
                </td>
                <td style="width: 25%">
                    {{ $owner->fiscal->num_documento }}
                </td>
            </tr>
            <tr>
                <td style="width: 25%">
                    <strong>FISCAL SUPLENTE</strong>
                </td>
                <td style="width: 50%">
                    {{ $owner->comisiones->firstWhere('nomcomision', 'FISCAL SUPLENTE')?->nomcomisionado }}
                </td>
                <td style="width: 25%">
                    {{ $owner->comisiones->firstWhere('nomcomision', 'FISCAL SUPLENTE')?->doccomisionado }}
                </td>
            </tr>

        </table>
        <p><strong>COMISIÓN CONCILIADORA</strong></p>
        <table border="1" style="width: 100%">
            @php
                $cargos = ['CONCILIADOR 1', 'CONCILIADOR 2', 'CONCILIADOR 3', 'CONCILIADOR 4'];
            @endphp

            @foreach ($cargos as $cargo)
                @php
                    $comision = $owner->comisiones->firstWhere('nomcomision', $cargo);
                @endphp
                @if ($comision)
                    <tr>
                        <td style="width: 25%">
                            <strong>{{ $cargo }}</strong>
                        </td>
                        <td style="width: 50%">
                            {{ $comision->nomcomisionado }}
                        </td>
                        <td style="width: 25%">
                            {{ $comision->doccomisionado }}
                        </td>
                    </tr>
                @endif
            @endforeach

        </table>
        <p><strong>SECRETARIAS</strong></p>
        <table border="1" style="width: 100%">
            @php
                $cargos = ['TRABAJO', 'SALUD', 'EDUCACION', 'DEPORTES', 'OBRAS', 'MEDIO AMBIENTE'];
            @endphp

            @foreach ($cargos as $cargo)
                @php
                    $comision = $owner->comisiones->firstWhere('nomcomision', $cargo);
                @endphp
                @if ($comision)
                    <tr>
                        <td style="width: 25%">
                            <strong>{{ $cargo }}</strong>
                        </td>
                        <td style="width: 50%">
                            {{ $comision->nomcomisionado }}
                        </td>
                        <td style="width: 25%">
                            {{ $comision->doccomisionado }}
                        </td>
                    </tr>
                @endif
            @endforeach
            {{-- AHORA TODOS LOS DE LAS COMISIONES PERSONALIZADAS --}}
            @php
                $cargos = [
                    'TRABAJO',
                    'SALUD',
                    'EDUCACION',
                    'DEPORTES',
                    'OBRAS',
                    'MEDIO AMBIENTE',
                    'CONCILIADOR 1',
                    'CONCILIADOR 2',
                    'CONCILIADOR 3',
                    'CONCILIADOR 4',
                    'FISCAL SUPLENTE',
                    'DELEGADO PRINCIPAL 1',
                    'DELEGADO SUPLEMENTE 1',
                    'DELEGADO PRINCIPAL 2',
                    'DELEGADO SUPLEMENTE 2',
                    'DELEGADO PRINCIPAL 3',
                    'DELEGADO SUPLEMENTE 3',
                    'DELEGADO PRINCIPAL 4',
                    'DELEGADO SUPLEMENTE 4',
                    'EMPRESARIAL',
                ];
                $otrasComisiones = $owner->comisiones->filter(function ($comision) use ($cargos) {
                    return !in_array($comision->nomcomision, $cargos);
                });
            @endphp

            @foreach ($otrasComisiones as $comision)
                <tr>
                    <td style="width: 25%">
                        <strong>{{ $comision->nomcomision }}</strong>
                    </td>
                    <td style="width: 50%">
                        {{ $comision->nomcomisionado }}
                    </td>
                    <td style="width: 25%">
                        {{ $comision->doccomisionado }}
                    </td>
                </tr>
            @endforeach
        </table>
        <p><strong>DELEGADOS A LA ASOCIACIÓN</strong></p>
        <table border="1" style="width: 100%">
            @php
                $cargos = [
                    'DELEGADO PRINCIPAL 1',
                    'DELEGADO SUPLEMENTE 1',
                    'DELEGADO PRINCIPAL 2',
                    'DELEGADO SUPLEMENTE 2',
                    'DELEGADO PRINCIPAL 3',
                    'DELEGADO SUPLEMENTE 3',
                    'DELEGADO PRINCIPAL 4',
                    'DELEGADO SUPLEMENTE 4',
                ];
            @endphp

            @foreach ($cargos as $cargo)
                @php
                    $comision = $owner->comisiones->firstWhere('nomcomision', $cargo);
                @endphp
                @if ($comision)
                    <tr>
                        <td style="width: 25%">
                            <strong>{{ $cargo }}</strong>
                        </td>
                        <td style="width: 50%">
                            {{ $comision->nomcomisionado }}
                        </td>
                        <td style="width: 25%">
                            {{ $comision->doccomisionado }}
                        </td>
                    </tr>
                @endif
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

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
        @php
            use Carbon\Carbon;

            $esAsociacion = ($certificado->tipo === 'Asociación' || isset($asociacion));
            $entidad = $junta ?? ($asociacion ?? null);

            // 1. Tipo de entidad diferenciador
            $tipoEntidadTexto = $esAsociacion ? 'Asociación Comunal de Juntas' : 'Junta de Acción Comunal';

            // 2. Conector inteligente 'del ' para el nombre de la entidad
            $rawNombre = trim($certificado->nombre_junta ?? ($entidad->nombre ?? ''));
            if (empty($rawNombre)) {
                $conector = 'del ';
                $nombreEntidad = '________';
            } elseif (preg_match('/^(del|de\s+la|de\s+los|de\s+las|de)\s+/i', $rawNombre)) {
                $conector = '';
                $nombreEntidad = $rawNombre;
            } else {
                $conector = 'del ';
                $nombreEntidad = $rawNombre;
            }

            // 3. Municipio
            $municipio = $certificado->comuna ?? ($entidad->municipio->nombre_municipio ?? '________');
            $municipioTexto = strtoupper($municipio);

            // 4. Personería jurídica (desde $entidad->personeria)
            $personeriaJuridica = !empty($entidad->personeria) ? $entidad->personeria : '________';

            // 5. Resolución y fecha de resolución (usando campos originales 'resolucion' y 'fecha_resolucion')
            $numResolucion = ($certificado->resolucion && $certificado->resolucion !== 'No Registra') 
                ? $certificado->resolucion 
                : (!empty($entidad->resolucion) ? $entidad->resolucion : '________');

            $fechaResolucionRaw = $certificado->fecha_resolucion ?? ($entidad->fecha_resolucion ?? null);
            $fechaResolucion = '________';
            if (!empty($fechaResolucionRaw)) {
                try {
                    $fechaResolucion = Carbon::parse($fechaResolucionRaw)->format('d/m/Y');
                } catch (\Exception $e) {
                    $fechaResolucion = $fechaResolucionRaw;
                }
            }

            // 6. Cargo con sufijo (A)
            $cargoRaw = $certificado->cargo ?? 'PRESIDENTE';
            $cargoTexto = str_contains($cargoRaw, '(A)') ? $cargoRaw : ($cargoRaw . ' (A)');

            // 7. Periodo dinámico con fallback
            $inicioPeriodo = null;
            $finalPeriodo = null;
            if (!empty($entidad->fecha_inicio_periodo)) {
                try {
                    $inicioPeriodo = Carbon::parse($entidad->fecha_inicio_periodo)->locale('es')->translatedFormat('d \d\e F \d\e Y');
                } catch (\Exception $e) {}
            }
            if (!empty($entidad->fecha_final_periodo)) {
                try {
                    $finalPeriodo = Carbon::parse($entidad->fecha_final_periodo)->locale('es')->translatedFormat('d \d\e F \d\e Y');
                } catch (\Exception $e) {}
            }

            if (!$inicioPeriodo || !$finalPeriodo) {
                if ($esAsociacion) {
                    $inicioPeriodo = '01 de septiembre de 2026';
                    $finalPeriodo = '31 de agosto de 2030';
                } else {
                    $inicioPeriodo = '01 de julio de 2026';
                    $finalPeriodo = '30 de junio de 2030';
                }
            }
            $periodoTexto = "{$inicioPeriodo} al {$finalPeriodo}";
        @endphp

        <p style="text-align: justify; margin: 0px 40px; line-height: 2;">
            Que, la {{ $tipoEntidadTexto }} {{ $conector }}{{ $nombreEntidad }}, del municipio de <strong>{{ $municipioTexto }}</strong>, Departamento Norte de Santander, identificada con la personería jurídica No. <strong>{{ $personeriaJuridica }}</strong>, expedida mediante resolución No. <strong>{{ $numResolucion }}</strong> del <strong>{{ $fechaResolucion }}</strong>, se encuentra inscrita y registrada en esta secretaría, su <strong>{{ $cargoTexto }}</strong> es <strong>{{ $certificado->nombre_dignatario ?? '________' }}</strong> identificado (a) con cédula No. <strong>{{ $certificado->documento_dignario ?? '________' }}</strong> reconocido (a) para el periodo <strong>{{ $periodoTexto }}</strong>.
        </p>
        <br>
        <p style="text-align: justify; margin: 0px 40px; line-height: 2;">
            La anterior se expide a solicitud del interesado.
        </p>
        <br>
        <br>
        @php
            if (!function_exists('numeroEnLetras')) {
                function numeroEnLetras($numero)
                {
                    $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
                    return $formatter->format($numero);
                }
            }
            $fecha = Carbon::parse($certificado->created_at);
            $dia = $fecha->day;
            $diaEnLetras = numeroEnLetras($dia);
            $diaConCero = str_pad($dia, 2, '0', STR_PAD_LEFT);
            $mesNombre = $fecha->locale('es')->translatedFormat('F');
            $anio = $fecha->year;
        @endphp
        <p style="margin: 0px 40px;">Dada en San José de Cúcuta a los {{ $diaEnLetras }} ({{ $diaConCero }}) días del mes de {{ $mesNombre }} de {{ $anio }}.</p>
        <br>
        <p style="text-align: justify; margin: 0px 40px; line-height: 2;">
            Nota: El número de certificado corresponde a la firma y autenticación de la constancia.
        </p>
    </div>
</body>

</html>

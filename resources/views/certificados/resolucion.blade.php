<!DOCTYPE html>
<html>

<head>
    <title>Resolucion</title>
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
        Resolucion N° {{ $auto->numero }}
        <center>
            Fecha {{ $diaConCero }} de {{ $mesNombre }} de {{ $anio }}
        </center>
        <p>
            "Por la cual se reconoce una Personeria Juridica a la Junta de Acción Comunal XXXXXXXXXX del municipio de
            XXXXXXXX del DEPARTAMENTO NORTE DE SANTANDER"
        </p>
        <p>
            LA SECRETARIA DE DESARROLLO SOCIAL DEL DEPARTAMENTO NORTE DE SANTANDER, en uso de sus facultades legales y
            en especial las conferidas por el articulo 76 numeral 1°. De la ley 2166 deciembre 18 de 2021, el decreto
            1774 del 2000 y el decreto 184 de 1.992 de la Gobernación y demás normas considerantes:
        </p>
        <center>
            <strong>CONSIDERANDO:</strong>
        </center>
        <p>
            QUE: eL Señor <strong>{{ $owner->nombre }}</strong>, identificado con c'edula de ciudadania No.
            <strong>{{ $owner->municipio->nombre_municipio }}</strong>, en su condicion de Presidente de la Junta de
            Accion Cumunal XXXXXXXXXXXXXXXXXXXx del Departamento Norte de Santander."
            constituida EN ASAMBLEA General de afiliados el XXX XXXXXXXX XXXXXXXXXXX; Presentó a ésta oficina
            documentación correspondiente a fin de obtener Personería Juridica de conformidad al articulo 11 y 12 de la
            ley 2166 de diciembre 18 de 2021, y de conformidad con el artículo 76 numeral 1° de la ley 2166 de diciembre
            18 de 2021. Y su decreto reglamentario. Articulo 2.3.2.1.1.1.
            <br>
            QUE: La Ley 52 de 1.990, el decreto 1774 del 2.000 El Decreto 184 de 1.992, la ley 2166 Articulo 76 Numeral
            1° faculta a las entidades de Inspección, vigilancia y control, para Otorgar, suspender y cancelar
            personería Jurídica de los oranismos de acción comunal...
        </p>
        <center>
            <strong>RESUELVE:</strong>
        </center>
        <p>
            Articulo 1° Reconocer Personeria Jurídica a la Junta de Acción Comunal XXXXXXXXXX del municipio de
            XXXXXXXX del DEPARTAMENTO NORTE DE SANTANDER con el No. XXXXXXXXXXXXXXXXXXXXx
            <br>
            Articulo 2° Aprobar los estatuto del citado organismo comunal, el cual deberá acogerse a las prescripciones
            de la ley 2166 de diciembre 18 de 2021 paragrafo 1. Artículo 15.
            <br>
            Articulo 3° La J.A.C tendrá como radio de accion los establecidos en su artículo 3° de los Estatutos
            <br>
            Articulo 4° Tener como representante legal de la junta al Presidente de la misma.
            <br>
            Articulo 5° Inscribir dicha Personería Jurídica en los libros que al respecto lleve la Secretaria de
            Desarrollo Social Departamental.
        </p>

        <p>Inscribir los dignatarios de la junta de Acción Comunal <strong>{{ $owner->nombre }}</strong>, Municipio
            <strong>{{ $owner->municipio->nombre_municipio }}</strong>, Departamento Norte de Santander. Para el
            periodo
            1 de julio de 2024 al 30 de junio de 2026.
        </p>

        <p>
            <strong>COMUNÍQUESE Y CÚMPLASE</strong>
            <br>
            Expedida en San José de Cúcuta, a los {{ $diaEnLetras }} ({{ $diaConCero }}) días del mes de
            {{ $mesNombre }} de {{ $anio }}.
        </p>
        <center>
            <img src="{{ public_path($config->keyfirma) }}" style="max-width: 220px; max-height: 120px;" />
            <h4>{{ $config->nombre_secretario }}<br>{{ $config->secretaria }}</h4>
        </center>
    </div>
</body>

</html>

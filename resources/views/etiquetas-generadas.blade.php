<!DOCTYPE html>
<html>
<head>
    <title>Etiquetas Generadas</title>
    <style>
        @page {
        margin: 0; /* Sin márgenes */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-left: 0;
            padding-right: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
            margin: 0;
        }
        .table th, .table td {
            border: 1px dotted #000;
            padding: 10px;
            vertical-align: middle;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .etiqueta {
            line-height: 0.1;
            white-space: pre-wrap;
        }
        @media print {
        body {
            margin: 0; /* Sin márgenes en el body */
            padding: 0;
            width: 100%; /* Asegura que el body ocupe todo el ancho */
            height: auto; /* Para evitar cualquier ajuste de altura */
        }
        .table {
            width: 100%;
            margin: 0; /* Sin márgenes en la tabla */
            border-collapse: collapse;
            page-break-inside: avoid; /* Evita que la tabla se divida entre páginas */
        }
        .table th, .table td {
            border: 1px dotted #000; /* Bordes punteados */
            padding: 10px;
            vertical-align: middle;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .etiqueta {
            line-height: 0.1;
            white-space: pre-wrap;
        }
    }
    </style>
</head>
<body>
    <table class="table">
        <tbody>
            @foreach (array_chunk($etiquetas, 3) as $row)
            <tr>
                @foreach ($row as $etiqueta)
                <td class="etiqueta">
                    {!! str_replace('*LOTE*', $etiqueta['lote'],
                            str_replace('*FECHA-ENVASADO*', $etiqueta['fecha_envasado'], $content))
                        !!}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

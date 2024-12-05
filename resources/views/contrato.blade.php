<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>CONTRATO</title>
  <style>
    @page {
    margin: 1cm; /* Establece un margen de 2 centímetros en todos los lados */
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.5;
        padding: 0 1cm; /* Agrega un espacio de 1 centímetro a los lados */
    }
    .logo-container {
      display: flex;
      align-items: center;

    }
    /* Estilo para la imagen del logo */
    .logo-container img {
      max-width: 150px; /* Ajusta el tamaño máximo del logo */
      height: auto;
      margin-right: 10px;
    }
    .logo-container h2 {
      flex-grow: 1; /* Hace que el título ocupe el espacio restante */
    }
    h1 {
    text-align: center;
    font-family: 'Calibri', sans-serif;
    }
    h2 {
      text-align: center;
      font-family: 'Calibri', sans-serif;
      margin: 0;
    }
    p{
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    }

    .fecha{
        font-family: 'Calibri', sans-serif;
        font-size: 12px;
        text-align: center;
    }

    .table1 {
        font-family: 'Calibri', sans-serif;
        font-size: 12px;
        border-collapse: collapse;
        width: 90%;
        margin: 0 auto;
    }
    .table1 th, .table1 td {
        padding: 8px; /* Espaciado interno */
        text-align: left; /* Alinear texto a la derecha */
        vertical-align: top; /* Alinear texto en la parte superior */
    }
    .table2 {
        font-family: 'Calibri', sans-serif;
        font-size: 12px;
        border-collapse: collapse;
        width: 90%;
        margin: 0 auto;
    }
    .table2 th, .table2 td {
        padding: 8px; /* Espaciado interno */

        vertical-align: top; /* Alinear texto en la parte superior */
    }
    .table3 {
        font-family: 'Calibri', sans-serif;
        font-size: 15px;
        border-collapse: collapse;
        width: 80%;
        margin: 0 auto;
        text-align: center;
        padding-top: 200px;
    }
    hr {
        border: 1; /* Elimina el borde por defecto */
        height: 2px; /* Altura de la línea */
        background-color: #000; /* Color de la línea */
        margin: 20px 0; /* Margen arriba y abajo */
    }
    .justify-text  {
        text-align: justify; /* Justifica el texto */
    }
  </style>
</head>
<body>
    <main>

    <div class="logo-container">
        <img src="{{ public_path('img/logo-eba.png') }}" alt="Logo">
    <h2>CONTRATO No. {{ $contrato->ctrt_codigo }}
        <p class="fecha">Fecha: {{ $contrato->ctrt_fecha }}</p>
    </h2>

    </div>
    <table class="table1">
        <tr>
          <td><strong>Vendedor:</strong> </td>
          <td><strong>{{ $contenido['ctrt_vendedor'] }}</strong><br>
            Av. Arce Edificio Hermanos Maldonado Nro. 2382, zona Sopocachi, La Paz - Bolivia
          </td>
        </tr>
        <tr>
          <td><strong>Comprador:</strong></td>
          <td><strong>{{ $contenido['ctrt_comprador'] }}</strong><br>
                      {{ $contenido['ctrt_direccion_comprador'] }}</td>
        </tr>
    </table>
    <hr>
    <p>Se confirma la presente venta, con especificaciones abajo detalladas:</p>
    <table class="table2">
        <tr>
            <td><strong>Producto:</strong></td>
            <td class="justify-text">{{ $contenido['ctrt_producto'] }}</td>
        </tr>
        <tr>
            <td><strong>Precio:</strong></td>
            <td class="justify-text">{{ $contenido['ctrt_precio_html'] }}</td>
        </tr>
        <tr>
            <td><strong>Términos de envio:</strong></td>
            <td class="justify-text">{{ $contenido['ctrt_terminos_envio'] }}</td>
        </tr>
        <tr>
            <td><strong>Embarque:</strong></td>
            <td class="justify-text">{{ $contenido['ctrt_embarque'] }}</td>
        </tr>
        <tr>
            <td><strong>Empaque:</strong></td>
            <td class="justify-text">{{ $contenido['ctrt_empaque'] }}</td>
        </tr>
        @if(!empty($contenido['selectedAnalisis']) && count($contenido['selectedAnalisis']) > 0)
        <tr>
            <td><strong>Análisis:</strong></td>
            <td>
                <ul>
                    @foreach ($contenido['selectedAnalisis'] as $analisis)
                    <li>{{ $analisis }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif
        <tr>
            <td><strong>Términos y condiciones:</strong></td>
            <td class="justify-text">{{ $contenido['ctrt_terminos'] }}</td>
        </tr>
        <tr>
            <td><strong>Pago:</strong></td>
            <td class="justify-text">{!! $contenido['ctrt_pago_html'] !!}</td>
        </tr>
        <tr>
            <td><strong>Documentos requeridos:</strong></td>
            <td class="justify-text">
                <u>Enviado por el vendedor</u>
                <br>
                {{ $contenido['ctrt_doc_vendedor'] }}
                <br>
                <u>Enviado por el comprador</u>
                <br>
                {{ $contenido['ctrt_doc_comprador'] }}
            </td>
        </tr>
        @if(!empty($contenido['ctrt_adicional_etiqueta']) && !empty($contenido['ctrt_adicional_contenido']))
        <tr>
            <td><strong>{{ $contenido['ctrt_adicional_etiqueta'] }}</strong></td>
            <td class="justify-text">{{ $contenido['ctrt_adicional_contenido'] }}</td>
        </tr>
        @endif
    </table>
    <table class="table3">
        <tr>
            <td><strong>Vendedor</strong></td>
            <td><strong>Comprador</strong></td>

        </tr>
    </table>
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(300, 750, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
                ');
            }
        </script>
</body>
</html>

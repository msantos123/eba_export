<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REGISTRO DE CONFORMACION DE CARGA</title>
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
    h3 {
      text-align: center;
      font-family: 'Calibri', sans-serif;
      margin: 0;
    }
    h4 {
      text-align: left;
      font-family: 'Calibri', sans-serif;
      margin: 0;
      width: 80%;
    }
    p{
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    }
    /* CSS DE TABLA 1 */
    .table3 {
    font-family: 'Calibri', sans-serif;
    font-size: 10px;
    border: 1px solid #333; /* Agregamos el color del borde */
    width: 90%;
    margin: 2 auto;
    border-collapse: collapse; /* Colapsamos los bordes de la tabla */
    }
    .table3 th, .table3 td {
    padding: 3px;
    text-align: center;
    border: 1px solid #333; /* Agregamos el color del borde a las celdas */
    }
    .table3 th {
    background-color: #e6e6e642;
    }
    .table3 td {
    width: 25%;
    }
    .table3 td:nth-child(1) { /* Seleccionamos la primera columna */
    width: 5%; /* Establecemos el ancho de la primera columna en 30% */
    }
    .table3 .total { /* Clase para la fila del total */
    font-weight: bold; /* Hacemos que la fila del total sea negrita */
    }
    .table3 tr:nth-child(1) { /* Seleccionamos la primera columna */
    text-align: center;
    font-weight: bold;
    }
    .top-right-image {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 100px;
    height: auto;
    }
  </style>
</head>
<body>
    <main>
    <div class="logo-container">
        <img src="{{ public_path('img/logo-eba.png') }}" alt="Logo">
    <h2>REGISTRO DE CONFORMACION DE LOTE</h2>
    <h3>{{ $solicitudcarga->codigo }}</h3>
    </div>
    <br>
  <table class="table3">
    @foreach ($cargas as $carga)
    <tr>
        <td colspan="6">DATOS DE CARGA</td>
    <tr>
    <tr>
        <th>#</th>
        <th>Producto</th>
        <th>Lote</th>
        <th>Cantidad</th>
        <th>Kilos Netos</th>
        <th>Libras Netas</th>
    </tr>
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $carga->nombre_producto }}</td>
        <td>{{ $carga->lote }}</td>
        <td>{{ $carga->cantidad }}</td>
        <td>{{ $carga->kilosnetos }}</td>
        <td>{{ $carga->librasnetas }}</td>
    </tr>
    <tr>
        <td colspan="6">DETALLE DE FECHAS DE LA CARGA</td>
    <tr>
        <tr>
            <th>#</th>
            <th>Lote</th>
            <th>Cantidad</th>
            <th>Fecha Elaboracion</th>
            <th>Fecha Envasado</th>
            <th>Fecha Vencimiento</th>
        </tr>
        @foreach ($carga->cargas_sigaSalidaDetalle as $detalle)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $detalle->lote_detalle }}</td>
            <td>{{ $detalle->cantidad_salida }}</td>
            <td>{{ $detalle->fecha_elaboracion }}</td>
            <td>{{ $detalle->fecha_envasado }}</td>
            <td>{{ $detalle->fecha_vencimiento }}</td>
        </tr>
        @endforeach
    @endforeach
  </table>

</footer>

</body>
</html>

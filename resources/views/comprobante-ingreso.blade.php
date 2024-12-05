<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>COMPROBANTE DE INGRESO</title>
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
    .table1 {
    font-family: 'Calibri', sans-serif;
    font-size: 14px;
    border-collapse: collapse; /* Agregamos esta propiedad para que se muestren las líneas de borde entre celdas */
    text-align: left;
    margin: 0 auto;
    width: 90%;
    }
    .table1 td:nth-child(1), .table1 td:nth-child(2) {
    float: left;
    width: 25%;
    font-weight: bold;
    }
    .table1 td:nth-child(3), .table1 td:nth-child(4) {
    float: right;
    width: 50%;
    }
    .table1 td:nth-child(5), .table1 td:nth-child(6) {
    float: right;
    width: 25%;
    font-weight: bold;
    }

    .table2 {
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    border-collapse: collapse; /* Agregamos esta propiedad para que se muestren las líneas de borde entre celdas */
    text-align: left;
    margin: 1 auto;
    width: 90%;
    border: 1px solid #333; /* Agregamos un borde sólido de 1px de ancho y color #333 */
    }
    .table2 th, .table2 td {
    border: 1px solid #333; /* Agregamos un borde sólido de 1px de ancho y color #333 a las celdas */
    padding: 3px;
    }
    .table2 tr:nth-child(1) { /* Seleccionamos la primera columna */
    text-align: center;
    font-weight: bold;
    }
    .table2 td:nth-child(1) { /* Seleccionamos la primera columna */
    width: 20%; /* Establecemos el ancho de la primera columna en 30% */
    font-weight: bold;
    }
    .table2 td:nth-child(2) { /* Seleccionamos la segunda columna */
    width: 30%; /* Establecemos el ancho de la segunda columna en 70% */
    }
    .table2 td:nth-child(3) { /* Seleccionamos la segunda columna */
    width: 10%; /* Establecemos el ancho de la segunda columna en 70% */
    font-weight: bold;
    }
    .table2 td:nth-child(4) { /* Seleccionamos la segunda columna */
    width: 30%; /* Establecemos el ancho de la segunda columna en 70% */
    }

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
    .table3 td:nth-child(2), .table3 td:nth-child(3), .table3 td:nth-child(4), .table3 td:nth-child(5){
    width: 70%;
    }
    .table3 td:nth-child(6), .table3 td:nth-child(7), .table3 td:nth-child(8){
    width: 20%;
    }
    .table3 .total { /* Clase para la fila del total */
    font-weight: bold; /* Hacemos que la fila del total sea negrita */
    }
    .table3 tr:nth-child(1) { /* Seleccionamos la primera columna */
    text-align: center;
    font-weight: bold;
    }

    .table4 {
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    width: 90%;
    margin: 2 auto;
    border-collapse: collapse; /* Colapsamos los bordes de la tabla */
    }
    .table4 th, .table4 td {
    text-align: left;
    border: 1px solid #333; /* Agregamos el color del borde a las celdas */
    }
    .table4 td:nth-child(1), .table4 td:nth-child(2){ /* Seleccionamos la primera columna */
    width: 50%; /* Establecemos el ancho de la primera columna en 30% */
    }

    .table5 {
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    border: 1px solid #333; /* Agregamos el color del borde */
    width: 90%;
    margin: 2 auto;
    border-collapse: collapse; /* Colapsamos los bordes de la tabla */
    }
    .table5 th, .table5 td {
    padding: 4px;
    text-align: left;
    border: 1px solid #333; /* Agregamos el color del borde a las celdas */
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
    <h2>COMPROBANTE DE INGRESO</h2>
    <h3>ALMACEN DE EXPORTACIONES EL ALTO</h3>
    </div>
    <br>
    <table class="table1">
        <tr>
          <td>Codigo N°: </td>
          <td>{{ $comprobanteIngreso->codigo_ingreso }}</td>
          <td></td>
          <td></td>
          <td>Fecha: </td>
          <td>{{ $comprobanteIngreso->fecha_ingreso }}</td>
        </tr>
    </table>
    <br>
    <table class="table2">
        <tr>
            <td colspan="4">DATOS DE TRANSPORTE</td>
        <tr>
          <td>Por cuenta de: </td>
          <td>Jose Luis Santos Castillo</td>
          <td>Camión: </td>
          <td>{{ $comprobanteIngreso->vehiculo }}</td>
        </tr>
        <tr>
          <td>Recibi de: </td>
          <td>{{ $comprobanteIngreso->conductor }}</td>
          <td>Placa: </td>
          <td>{{ $comprobanteIngreso->placa }}</td>
        </tr>
        <tr>
          <td>Transporte: </td>
          <td>{{ $comprobanteIngreso->empresa }}</td>
          <td>Nro Cefo: </td>
          <td>{{ $comprobanteIngreso->cefo }}</td>
        </tr>
        <tr>
          <td>Proveedor: </td>
          <td>{{ $comprobanteIngreso->planta }}</td>
          <td>Licencia: </td>
          <td>{{ $comprobanteIngreso->licencia }}</td>
        </tr>
        <tr>
          <td>Conocimiento Carga: </td>
          <td>{{ $comprobanteIngreso->codigo }}</td>
          <td>Celular: </td>
          <td>{{ $comprobanteIngreso->celular }}</td>
        </tr>
      </table>

      <br>
  <table class="table3">
    <tr>
        <td colspan="8">DATOS DE CARGA</td>
    <tr>
    <tr>
        <th>#</th>
        <th>Codigo</th>
        <th>Producto</th>
        <th>Descripcion</th>
        <th>Lote</th>
        <th>Cantidad</th>
        <th>Kilos Netos</th>
        <th>Libras Netas</th>
    </tr>
    @foreach ($cargas as $carga)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $carga->codigo_producto }}</td>
        <td>{{ $carga->nombre_producto }}</td>
        <td>{{ $carga->descripcion }}</td>
        <td>{{ $carga->lote }}</td>
        <td>{{ $carga->cantidad }}</td>
        <td>{{ $carga->kilosnetos }}</td>
        <td>{{ $carga->librasnetas }}</td>
    </tr>
    @endforeach
    <tr class="total">
        <td colspan="5">Total:</td>
        <td>{{ $comprobanteIngreso->total_cantidad }}</td>
        <td>{{ $comprobanteIngreso->total_kilosnetos }}</td>
        <td>{{ $comprobanteIngreso->total_librasnetas }}</td>
    </tr>
  </table>
  <table class="table5">
    <tr>
        <td>Observaciones: {{ $comprobanteIngreso->observaciones }}</td>
    </tr>
  </table>
</main>
<footer>
    <br>
    <table class="table4">
        <tr>
          <td style="height: 120px; vertical-align: bottom; text-align: center;"><b>Firma</b></td>
          <td style="vertical-align: bottom; text-align: center; font-size: 10px;" rowspan="5">"Acepto haber recibido esta carga en perfectas condiciones."</td>
        </tr>
        <tr>
            <td>Nombre: </td>
        </tr>
        <tr>
            <td>Cargo: </td>
        </tr>
        <tr>
            <td>CI: </td>
        </tr>
        <tr>
            <td>Celular: </td>
        </tr>
        <tr>
            <td style="vertical-align: bottom; text-align: center;"><b>Entregue Conforme</b></td>
            <td style="vertical-align: bottom; text-align: center;"><b>Recibi Conforme</b></td>
        </tr>
      </table>
</footer>

</body>
</html>

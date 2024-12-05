<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>CONOCIMIENTO DE CARGA</title>
  <style>
    @page {
    margin: 1cm; /* Establece un margen de 2 centímetros en todos los lados */
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.5;
        padding: 0 1cm; /* Agrega un espacio de 1 centímetro a los lados */
        position: relative;
        overflow: hidden; /* Asegúrate de que no haya desbordamiento */
    }
    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
        font-size: 200px;
        color: rgba(0, 0, 0, 0.1); /* Opacidad del texto */
        pointer-events: none; /* Evitar que interfiera con otros elementos */
        white-space: nowrap; /* Evitar que el texto se divida */
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
    .table1 {
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    border-collapse: collapse;
    width: 80%;
    margin: 0 auto;
    }
    .table1 th, .table1 td {
    padding: 2px;
    text-align: left;
    }

    .table1 th, .table1 td {
    width: 10%;
    }
    .table1 td:first-child {
    width: 30%;
    }
    .table1 td:last-child {
    width: 70%;
    }

    .table2 {
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    border-collapse: collapse;
    width: 80%;
    margin: 0 auto;
    }
    .table2 th, .table2 td {
    padding: 2px;
    text-align: left;
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
  padding: 4px;
  text-align: left;
  border: 1px solid #333; /* Agregamos el color del borde a las celdas */
}

.table3 th {
  background-color: #e6e6e642;
}

/* Especificar el ancho de las columnas */
.table3 th:nth-child(1),
.table3 td:nth-child(1) {
  width: 5%; /* Ancho para la primera columna */
}

.table3 th:nth-child(2),
.table3 td:nth-child(2) {
  width: 15%; /* Ancho para la segunda columna */
}

.table3 th:nth-child(3),
.table3 td:nth-child(3) {
  width: 50%; /* Ancho más grande para la tercera columna */
}


.table4 {
    font-family: 'Calibri', sans-serif;
    font-size: 14px;
    border-collapse: collapse;
    width: 80%;
    margin: 0 auto;
}
.table4 td {

  text-align: center;
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
    <div class="watermark">Borrador</div> <!-- Marca de agua -->
    <main>

    <div class="logo-container">
        <img src="{{ public_path('img/logo-eba.png') }}" alt="Logo">
    <h2>CONOCIMIENTO DE CARGA <br>{{ $conocimientos->planta }} – {{ $conocimientos->codigo }}</h2>
    </div>
    <br>
    <table class="table1">
        <tr>
          <td>Producto de: </td>
          <td>Empresa Boliviana de Alimentos y Derivados - EBA</td>
        </tr>
        <tr>
          <td>Planta de Origen: </td>
          <td>{{ $conocimientos->planta }}</td>
        </tr>
        <tr>
            <td>Consignatario: </td>
            <td>Empresa Boliviana de Alimentos y Derivados - EBA<br>
                Atn: Jose Luis Santos Castillo<br>
                Zona Villa Mercedes E Av. Simon Bolivar #2010<br>
                Almacen de Exportaciones EL ALTO – LA PAZ<br>
            </td>
        </tr>
        <tr>
            <td>Empresa: </td>
            <td>{{ $conocimientos->empresa }}</td>
        </tr>
    </table>
    <table class="table2">
        <tr>
            <td>Conductor: </td>
            <td>{{ $conocimientos->conductor }}</td>
            <td>Vehiculo: </td>
            <td>{{ $conocimientos->vehiculo }}</td>
        </tr>
        <tr>
            <td>Propietario: </td>
            <td>{{ $conocimientos->propietario }}</td>
            <td>Licencia: </td>
            <td>{{ $conocimientos->licencia }}</td>
        </tr>
        <tr>
            <td>Placa: </td>
            <td>{{ $conocimientos->placa }}</td>
            <td>Celular Chofer:: </td>
            <td>{{ $conocimientos->celular }}</td>
        </tr>
      </table>

      <br>
  <table class="table3">
    <tr>
        <th>#</th>
        <th>Codigo</th>
        <th>Producto</th>
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
        <td>{{ $carga->lote }}</td>
        <td>{{ $carga->cantidad }}</td>
        <td>{{ $carga->kilosnetos }}</td>
        <td>{{ $carga->librasnetas }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4">Total:</td>
        <td>{{ $conocimientos->total_cantidad }}</td>
        <td>{{ $conocimientos->total_kilosnetos }}</td>
        <td>{{ $conocimientos->total_librasnetas }}</td>
    </tr>
  </table>

<p>(*) Cajas de 20kg (44 lb) neto: 21kg bruto

  <p>El transportista se compromete a efectuar la entrega a la carga,
    manteniendo la integridad y calidad del producto, tal como la recibio.
    En caso de que la carga muestre indicios de maltrato y el producto sea
    irrecuperable, roturas, suciedad o haya sufrido cualquie tipo de contaminació,
    se aplicara un descuento del equivalente a USD. 210.- por cada caja en mal estado.<nav></nav>
  </p>
  <br><br><br><br><br><br><br>


</main>
<footer>
    <table class="table4">
        <tr>
        <td>{{ $conocimientos->usuario }} </td>
        <td>{{ $conocimientos->conductor }}</td>
        </tr>
        <tr>
        <td>ENTREGUE CONFORME </td>
        <td>RECIBIO CONFORME</td>
        </tr>
    </table>
</footer>

</body>
</html>

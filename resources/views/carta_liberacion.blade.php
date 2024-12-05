<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>SOLICITUD DE EXPRESS RELEASE</title>
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
    .table1 {
    font-family: 'Calibri', sans-serif;
    font-size: 12px;
    border-collapse: collapse;
    width: 100%;
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
    width: 20%;
    }
    .table1 td:last-child {
    width: 80%;
    }

.table4 {
    font-family: 'Calibri', sans-serif;
    font-size: 14px;
    border-collapse: collapse;
    width: 90%;
    margin: 0 auto;
}
.table4 td {

  text-align: left;
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
    <h2>SOLICITUD DE EXPRESS RELEASE</h2>
    </div>
    <br>
    <div>
        <p><strong> {{ $liberacion->updated_at }}</strong></p>
    </div>
    <div>
        <p><strong>
            Señores <br>
            MSC BOLIVIA LTDA <br>
            Departamento Comercial Exportaciones <br>
           <u> Presente:</u></strong></p>
    </div>
    <table class="table1">
        <tr>
            <td><strong> Nave / Viaje: </strong></td>
            <td>{{ $liberacion->libe_nave_viaje }}</td>
        </tr>
        <tr>
            <td><strong>Bill Of Lading: </strong></td>
            <td>{{ $liberacion->libe_bl }}</td>
        </tr>
        <tr>
            <td><strong>Puerto de descarga: </strong></td>
            <td>{{ $liberacion->libe_puerto }}</td>
        </tr>
        <tr>
            <td><strong>Consignatario: </strong></td>
            <td>{{ $liberacion->libe_consignatario }}</td>
        </tr>
        <tr>
            <td></td>
            <td>ADD.: {{ $liberacion->libe_direccion }}</td>
        </tr>
    </table>
<p><strong><u> REF: AUTORIZACION EXPRESS RELEASE </u></strong></p>
<p>Nosotros, Empresa Boliviana de Alimentos y Derivados - EBA, como embarcadores de la carga en
    referencia, confirmamos que autorizamos la instrucción de Express Release. Asimismo, confirmamos
    y aceptamos los términos y condiciones de las cláusulas del Sea Waywill.
  </p>
  <p>Sin otro particular, me despido atentamente</p>
  <p><i>Generado por: {{ $liberacion->usuario }}</i></p>
  <br><br><br><br><br><br><br>


</main>
<footer>
    <table class="table4">
        <tr>
        <td></td>
        <td></td>
        <td></td>
        </tr>
        <tr>
            <td>Sello y Firma del Revisor</td>
            <td></td>
            <td>Sello y Firma del Embarcador</td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td></td>
            <td>Nombre: Roberto Ojeda Marguay</td>
        </tr>
        <tr>
            <td>Cargo: Profesional Administrativo Financero</td>
            <td></td>
            <td>Cargo: Jefe del Departamento de Comercio Exterior</td>
        </tr>
        <tr>
            <td>C.I.:</td>
            <td></td>
            <td>C.I.: 4803885 LP.</td>
        </tr>
    </table>
</footer>

</body>
</html>

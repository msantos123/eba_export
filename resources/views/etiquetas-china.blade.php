<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale-1.0">
    <meta http-equiv = "X-UA-Compatible" content="ie=edge">
    <title>Etiquetas Generadas</title>
    <style>
        @font-face{
            font-family: "Simsun";
            src: url('{{ storage_path('fonts/Simsun.ttf') }}') format('truetype');
            font-weight: 100;
            font-style: normal;
        }
        @page {
        margin: 0; /* Sin márgenes */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: a    void;
            margin: 1 auto;

        }
        .table th, .table td {
            border: 0.5px dotted #000;
            padding-top: 6px;
            padding-bottom: 6px;
            padding-left: 10px;
            vertical-align: middle;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .simsun{
            font-family: "Simsun";
            font-size: 9pt;
            border: 1px;
            vertical-align: center;
            margin: 0 auto;
        }
        .simsun td, .simsun tr {
            padding: 0; /* Elimina el espacio interno */
            margin: 0; /* Elimina el margen */
            border: 1px; /* Asegúrate de que no haya bordes en la tabla interna */
        }
        .no-border {
            border: none; /* Sin bordes */
            padding: 0; /* Sin padding */
            margin: 0; /* Sin margin */
        }
        .text-large {
            font-size: 12pt; /* Ajusta el tamaño de la fuente como desees */
        }
        .text-smile {
            font-size: 8pt; /* Ajusta el tamaño de la fuente como desees */
        }
        .simsun tr , .simsun td{
            line-height: 1; /* Controla la altura de línea */
        }
        .center{
            text-align: center;
        }
    </style>
</head>
<body>
    <table class="table">
        <tbody>
            @foreach (array_chunk($etiquetas, 3) as $row)
            <tr>
                @foreach ($row as $etiqueta)
                <td>
                    <table class="simsun no-border">
                        <tr ><td class="text-large">品名：</td>     <td class="text-large">去壳巴西坚果 </td></tr>
                        <tr><td>配料：</td>     <td>巴西坚果 </td></tr>
                        <tr><td>原产国: </td>   <td>玻利维亚 </td></tr>
                        <tr><td class="text-large">净含量: </td>   <td class="text-large">20kg </td></tr>
                        <tr><td>规格:</td>      <td>{{ $etiqueta['tipo'] }} </td></tr>
                        <tr><td>批号:</td>      <td>{{ $etiqueta['lote'] }}</td></tr>
                        <tr><td>生产日期：</td> <td>{{ $etiqueta['anoEnvasado'] }} 年 {{ $etiqueta['mesEnvasado'] }} 月 {{ $etiqueta['diaEnvasado'] }} 日</td></tr>
                        <tr><td>保质期(至)</td><td>{{ $etiqueta['anoVencimiento'] }} 年 {{ $etiqueta['mesVencimiento'] }} 月 {{ $etiqueta['diaVencimiento'] }} 日</td></tr>
                        <tr><td>储存方法：</td>   <td>请置于阴凉干燥处 </td></tr>
                        <tr><td>在华注册编号</td>   <td>CBOL12012209210001</td></tr>
                        <tr><td>进口商：</td>   <td>北京臻味坊食品有限公司</td></tr>
                        <tr><td class="text-smile">进口商地址</td>   <td class="text-smile">北京市房山区周口店镇瓦梨路1号</td></tr>
                        <tr><td>电话：</td>   <td>010-67685888</td></tr>
                        <tr><td>备注：</td>   <td>本产品非零售</td></tr>
                        <tr><td colspan="2" class="center">本产品输往中华人民共和国</td></tr>
                        <tr><td colspan="2" class="center">This Product is Exported to The People’s <br> Republic Of China</td></tr>
                    </table>
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

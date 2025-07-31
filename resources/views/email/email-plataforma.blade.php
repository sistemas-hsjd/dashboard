<!DOCTYPE html>
<html lang="es-cl">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: Arial, Helvetica, sans-serif !important;
        }

        table, table td, table th {
            font-size: 12px; /* O cualquier tamaño más pequeño que prefieras */
        }

        .container {
            text-align: left;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: left;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }

        table{
            border: 1px solid black;
            border-collapse: collapse;
        }

        table tr td{
            border: 1px solid black;
        }
        #saludo{
            margin:10px 0 10px 0;
        }
        #info{
            margin:10px 0 15px 0;
        }

      
        table thead tr td{
            font-weight:bold;
        }

        div.centerTable{
         text-align: center !important;
        }

        div.centerTable table {
            margin: 0 auto !important;
            text-align: left;
        }

    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>

</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif;">
    <div class="container">
        <div class="content">
            <div id="saludo">{{ $mensaje }}</div>
            <br>
        </div>
            <div id="info">
                <table class="table" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; border: 1px solid #dddddd;">
                    <thead>
                      <tr tyle="background-color: #f8f9fa;">
                        <th style="border: 1px solid #dddddd;">RUN</th>
                        <th style="border: 1px solid #dddddd;">Nombre Completo</th>
                        <th style="border: 1px solid #dddddd;">Email</th>
                        <th style="border: 1px solid #dddddd;">Teléfono</th>
                        <th style="border: 1px solid #dddddd;">Estamento</th>
                        <th style="border: 1px solid #dddddd;">Unidad</th>
                         @if ($data[0]['estamento']=='BECADO')
                            <th style="border: 1px solid #dddddd;">RUN Tutor</th>
                            <th style="border: 1px solid #dddddd;">Inicio Rotación</th>
                            <th style="border: 1px solid #dddddd;">Término Rotación</th>
                         @endif

                        <th style="border: 1px solid #dddddd;">Sistemas</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                           <tr style="background-color: #f8f9fa;">
                                <th style="border: 1px solid #dddddd;"><?php echo $value['run']; ?></th>
                                <td style="border: 1px solid #dddddd;"><?php echo $value['nombre_completo']; ?></td>
                                <td style="border: 1px solid #dddddd;"><?php echo $value['email']; ?></td>
                                <td style="border: 1px solid #dddddd;"><?php echo $value['telefono']; ?></td>
                                <td style="border: 1px solid #dddddd;"><?php echo $value['estamento']; ?></td>
                                <td style="border: 1px solid #dddddd;"><?php echo $value['nombre_unidad']; ?></td>
                                 @if ($value['estamento']=='BECADO' || $value['estamento']=='INTERNO')
                                    <td style="border: 1px solid #dddddd;"><?php echo $value['RUN_tutor']; ?></td>
                                    <td style="border: 1px solid #dddddd;"><?php echo $value['inicio_rotacion']; ?></td>
                                    <td style="border: 1px solid #dddddd;"><?php echo $value['fin_rotacion']; ?></td>
                                 @endif
                                <td style="border: 1px solid #dddddd;">
                                    <ul>
                                        <li><?php echo $value['sistema']; ?></li>
                                    </ul>
                                </td>
                           </tr>
                        @endforeach
                   
                    </tbody>
                  </table>
               
            
            </div>
                

        </div>
    </div>
</body>
</html>
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
    <title>Notificación NEA</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif;">
    <div class="container">
        <div class="content">
            <div id="saludo">Estimado(a), Junto con saludar y esperando que se encuentre bien</div>
            <div id="info">Tiene una notificación de corrección de <strong> Matriz de Análisis de Eventos Adverso ID <?php echo $data['id']; ?></strong> <br><br>
                El cuál presenta </strong> mejoras posibles <br>
                Con fecha <?php echo $data['fc_analisis']; ?><br> 
                <?php echo $data['suceso']; ?>
                <br>
            </div>
        </div>
    </div>
</body>
</html>
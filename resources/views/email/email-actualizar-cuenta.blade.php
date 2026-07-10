<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de actualización de cuenta</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:14px;
            color:#333;
            background:#f5f5f5;
            margin:0;
            padding:20px;
        }

        .container{
            max-width:700px;
            margin:0 auto;
            background:#ffffff;
            border:1px solid #ddd;
            border-radius:6px;
            overflow:hidden;
        }

        .header{
            background:#0d6efd;
            color:#fff;
            padding:15px 20px;
        }

        .body{
            padding:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        table td{
            padding:10px;
            border:1px solid #ddd;
            vertical-align: top;
        }

        .label{
            width:220px;
            background:#f8f9fa;
            font-weight:bold;
        }

        ul{
            margin:0;
            padding-left:20px;
        }

        .footer{
            padding:15px 20px;
            background:#f8f9fa;
            color:#777;
            font-size:12px;
            text-align:center;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <h2>Solicitud de actualización de cuenta</h2>
    </div>

    <div class="body">

        <p>{{ $mensaje }}</p>

        <p>Se ha recibido una solicitud para actualizar la información de la siguiente cuenta:</p>

        <table>

            <tr>
                <td class="label">Nombre</td>
                <td>{{ $data['usuario']->nombre }}</td>
            </tr>

            <tr>
                <td class="label">RUN</td>
                <td>{{ $data['usuario']->rut }}</td>
            </tr>

            <tr>
                <td class="label">Correo registrado</td>
                <td>{{ $data['usuario']->email_recuperacion ?? 'Sin correo registrado' }}</td>
            </tr>

            <tr>
                <td class="label">Correo solicitado</td>
                <td>{{ $data['email'] }}</td>
            </tr>

            <tr>
                <td class="label">Estamento</td>
                <td>{{ $data['estamento'] }}</td>
            </tr>

            <tr>
                <td class="label">Unidades solicitadas</td>
                <td>
                    @if(!empty($data['unidades']))
                        <ul>
                            @foreach($data['unidades'] as $unidad)
                                <li>{{ $unidad }}</li>
                            @endforeach
                        </ul>
                    @else
                        Sin unidades asociadas
                    @endif
                </td>
            </tr>

            <tr>
                <td class="label">Último acceso</td>
                <td>{{ $data['usuario']->ultimo_acceso ?? 'Sin información' }}</td>
            </tr>

            <tr>
                <td class="label">Fecha de creación de la cuenta</td>
                <td>
                    {{ \Carbon\Carbon::parse($data['usuario']->created_at)->format('d/m/Y H:i') }}
                </td>
            </tr>

        </table>

        <br>

        <p>
            Favor revisar la información del usuario y realizar la actualización de la cuenta en caso de corresponder.
        </p>

    </div>

    <div class="footer">
        Este correo fue generado automáticamente por el Portal de Solicitud de Cuentas del Hospital San Juan de Dios.
        <br>
        Por favor, no responda este mensaje.
    </div>

</div>

</body>
</html>
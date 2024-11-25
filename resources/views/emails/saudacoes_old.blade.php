<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Pin</title>
    @section('adminlte_css_pre')
    <link rel="icon" href="{{ URL::asset('img/logo.png') }}" type="image/x-icon" />
    @stop
</head>

<body>
    <h4>Prezado {{$nome}} </h4>

    <p>Seu cadastro foi realizado com sucesso no sistema hsCidadao. </p>

    <p>Por meio dele, você poderá encaminhar Protocolos, acessar o Sistema de Informação do Cidadão e Ouvidoria da sua cidade.</p>

    <p>Atenciosamente,</p>

    <p>Equipe HardSoft</p>
    <br><br>
    <img style="width:150px;" src="{{ $message->embed('vendor/adminlte/dist/img/logo.jpg') }}" alt="Logo Aqui">
</body>

</html>
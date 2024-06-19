<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Confirmação de Permanência</title>
</head>

<body>
    <h1>Confirmação de Permanência</h1>
    <p>Olá {{ $nome }},</p>
    <p>Sua permanência foi confirmada para a seguinte data: {{ $dataConfirmacao->format('d/m/Y H:i') }}.</p>
    <p>O evento foi agendado no Google Calendar.</p>
</body>

</html>

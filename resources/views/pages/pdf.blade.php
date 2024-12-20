<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tabela de Permanências</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Tabela de Permanências</h2>
        <p>Data de Geração: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Disciplina</th>
                <th>Professor</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Sala</th>
                <th>Curso</th>
                <th>Turno</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $dado)
                <tr>
                    <td>{{ $dado->disciplina }}</td>
                    <td>{{ $dado->nome_do_professor }}</td>
                    <td>{{ \Carbon\Carbon::parse($dado->data)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($dado->hora_inicio)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($dado->hora_fim)->format('H:i') }}</td>
                    <td>{{ $dado->sala }}</td>
                    <td>{{ $dado->curso }}</td>
                    <td>{{ $dado->turno }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Documento gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>

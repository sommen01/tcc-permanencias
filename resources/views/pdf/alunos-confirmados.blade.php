<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Alunos Confirmados</title>
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
        <h2>Relatório de Alunos Confirmados</h2>
        <p>Professor: {{ $professor->name }}</p>
        <p>Data de Geração: {{ $dataGeracao }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Curso</th>
                <th>Email</th>
                <th>Permanência</th>
                <th>Horário</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($confirmacoes as $confirmacao)
                <tr>
                    <td>{{ $confirmacao->nome_aluno }}</td>
                    <td>{{ $confirmacao->curso }}</td>
                    <td>{{ $confirmacao->email_aluno }}</td>
                    <td>{{ Carbon\Carbon::parse($confirmacao->data)->format('d/m/Y') }} - {{ $confirmacao->disciplina }}
                    </td>
                    <td>{{ Carbon\Carbon::parse($confirmacao->hora_inicio)->format('H:i') }} -
                        {{ Carbon\Carbon::parse($confirmacao->hora_fim)->format('H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

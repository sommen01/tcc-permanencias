<!DOCTYPE html>
<html>

<head>
    <title>Tabela PDF</title>
    <style>
        body {
            /* background-image: url('{{ public_path('assets/img/logo-ifms.png') }}'); */
            background-size: cover;
            background-position: center;
            opacity: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            opacity: 1;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Tabela de Permanências</h1>
    <table>
        <thead>
            <tr>
                <th>Dia da Semana</th>
                <th>Hora de Início</th>
                <th>Hora de Término</th>
                <th>Disciplina</th>
                <th>Turno</th>
                <th>Professor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $dado)
                <tr>
                    <td>{{ $dado->dia_semana_nome }}</td>
                    <td>{{ $dado->hora_inicio }}</td>
                    <td>{{ $dado->hora_fim }}</td>
                    <td>{{ $dado->disciplina }}</td>
                    <td>{{ $dado->turno }}</td>
                    <td>{{ $dado->professor->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

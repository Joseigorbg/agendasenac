<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Agendamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Detalhes do Agendamento</h1>
    </div>

    <div class="content">
        <table class="table">
            <tr>
                <th>Instrutor</th>
                <td>{{ $agendamento->instrutor }}</td>
            </tr>
            <tr>
                <th>Sala</th>
                <td>{{ $agendamento->sala }}</td>
            </tr>
            <tr>
                <th>Data de Início</th>
                <td>{{ \Carbon\Carbon::parse($agendamento->data_inicio)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Data de Fim</th>
                <td>{{ \Carbon\Carbon::parse($agendamento->data_fim)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Turno</th>
                <td>{{ ucfirst($agendamento->turno) }}</td>
            </tr>
            <tr>
                <th>Equipamentos</th>
                <td>
                    @if($agendamento->equipamentos)
                        @foreach($agendamento->equipamentos as $key => $value)
                            {{ ucfirst($key) }}: {{ $value }} <br>
                        @endforeach
                    @else
                        Nenhum equipamento selecionado.
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>

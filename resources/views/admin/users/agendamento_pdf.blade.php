<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Agendamento</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fdfdfd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #333;
            font-size: 24px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid #ddd;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #333;
        }
        .equipamentos {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .equipamentos label {
            font-weight: bold;
            color: #333;
        }
        .equipamento-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Detalhes do Agendamento</h1>
    </div>

    <h3>Detalhes do Usuário</h3>
    <p><strong>Nome:</strong> {{ $user->name }}</p>
    <p><strong>Matrícula:</strong> {{ $user->matricula }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Cargo:</strong> {{ ucfirst($user->cargo) }}</p>

    <h3>Detalhes do Agendamento</h3>
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
                <div class="equipamentos">
                    @if(!empty($agendamento->equipamentos))
                        @foreach (['notebooks', 'projetor', 'camera_fotografica', 'tripe', 'fonte_caixa_som', 'microfone', 'caneta_quadro_interativo', 'controle_tv', 'controle_projetor'] as $equipamento)
                            @if(isset($agendamento->equipamentos[$equipamento]))
                                <div class="equipamento-item">
                                    <label>{{ ucfirst(str_replace('_', ' ', $equipamento)) }}</label>
                                    <span>{{ $agendamento->equipamentos[$equipamento]['quantity'] ?? '0' }}</span>
                                </div>
                            @endif
                        @endforeach
                    @else
                        Nenhum equipamento solicitado.
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>

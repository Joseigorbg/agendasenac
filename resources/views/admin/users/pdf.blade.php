<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Usuário</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 14px; 
            color: #333;
            margin: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
        }
        .header h2 { 
            margin: 0; 
            padding: 0; 
            font-size: 24px; 
            color: #1D4ED8; /* Tailwind's blue-700 */ 
        }
        .section { 
            margin-bottom: 20px; 
        }
        .section h3 { 
            margin-bottom: 10px; 
            font-size: 18px; 
            color: #1D4ED8; 
            border-bottom: 1px solid #ddd; 
            padding-bottom: 5px;
        }
        .details p { 
            margin: 5px 0; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #1D4ED8; 
            color: white; 
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Detalhes do Usuário</h2>
    </div>

    <div class="section details">
        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Nome:</strong> {{ $user->name }}</p>
        <p><strong>Matrícula:</strong> {{ $user->matricula }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Cargo:</strong> {{ ucfirst($user->cargo) }}</p>
        <p><strong>Data de Criação:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section agendamentos">
        <h3>Agendamentos</h3>
        @if($agendamentos->isEmpty())
            <p>Este usuário não possui agendamentos.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Instrutor</th>
                        <th>Sala</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Turno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agendamentos as $agendamento)
                        <tr>
                            <td>{{ $agendamento->id }}</td>
                            <td>{{ $agendamento->instrutor }}</td>
                            <td>{{ $agendamento->sala }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->data_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->data_fim)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($agendamento->turno) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer">
        <p>Agendasenac &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>

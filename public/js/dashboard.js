document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Pizza (Status dos Agendamentos)
    var statusData = {
        labels: ['Entrada', 'Saída'],
        datasets: [{
            data: statusDataValues, // Os valores dinâmicos do Blade
            backgroundColor: ['#4CAF50', '#F44336'],
        }]
    };

    var statusPieChart = new Chart(document.getElementById('statusPieChart'), {
        type: 'pie',
        data: statusData
    });

    var turnosData = {
        labels: ['Manhã', 'Tarde', 'Noite'],
        datasets: [{
            label: 'Agendamentos por Turno',
            data: turnosDataValues,
            backgroundColor: ['#FFEB3B', '#03A9F4', '#673AB7'],
        }]
    };

    var turnosBarChart = new Chart(document.getElementById('turnosBarChart'), {
        type: 'bar',
        data: turnosData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });

    // Gráfico de Barras (Equipamentos Mais Solicitados)
    var equipamentosData = {
        labels: equipamentosLabels,
        datasets: [{
            label: 'Quantidade de Equipamentos',
            data: equipamentosDataValues,
            backgroundColor: '#42A5F5'
        }]
    };

    var equipamentosBarChart = new Chart(document.getElementById('equipamentosBarChart'), {
        type: 'bar',
        data: equipamentosData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

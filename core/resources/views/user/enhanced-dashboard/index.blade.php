@extends('userlayout')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-8">
                        <h1 class="display-4 text-dark">Dashboard Avançado</h1>
                        <p class="text-dark">Visão completa do seu negócio em tempo real</p>
                    </div>
                    <div class="col-lg-4 text-right">
                        <button class="btn btn-sm btn-neutral" onclick="refreshDashboard()">
                            <i class="fas fa-sync-alt"></i> Atualizar
                        </button>
                        <button class="btn btn-sm btn-primary" onclick="exportReport()">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Cards de Métricas Principais -->
                <div class="row">
                    <!-- Saldo Disponível -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Saldo Disponível</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $dashboardData['balance']['formatted']['available'] ?? 'R$ 0,00' }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $dashboardData['balance']['projection']['formatted']['next_7_days'] ?? '+R$ 0,00' }}</span>
                                    <span class="text-nowrap text-muted">próximos 7 dias</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Receita do Mês -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Receita do Mês</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $dashboardData['revenue']['formatted']['this_month'] ?? 'R$ 0,00' }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    @if(($dashboardData['revenue']['growth_percentage'] ?? 0) >= 0)
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ number_format(abs($dashboardData['revenue']['growth_percentage'] ?? 0), 1) }}%</span>
                                    @else
                                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{ number_format(abs($dashboardData['revenue']['growth_percentage'] ?? 0), 1) }}%</span>
                                    @endif
                                    <span class="text-nowrap text-muted">vs. mês anterior</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Transações Hoje -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Transações Hoje</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $dashboardData['transactions']['today_count'] ?? 0 }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-info mr-2">{{ $dashboardData['transactions']['conversion_rate'] ?? 0 }}%</span>
                                    <span class="text-nowrap text-muted">taxa de conversão</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Taxa de Conversão -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Ticket Médio</h5>
                                        <span class="h2 font-weight-bold mb-0">R$ {{ number_format($dashboardData['performance']['average_order_value'] ?? 0, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-purple text-white rounded-circle shadow">
                                            <i class="fas fa-tags"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-purple mr-2">{{ $dashboardData['performance']['refund_rate'] ?? 0 }}%</span>
                                    <span class="text-nowrap text-muted">taxa de reembolso</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <!-- Gráfico de Receita -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Receita dos Últimos 30 Dias</h3>
                            </div>
                            <div class="col text-right">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" onclick="updateChart('7d')">7 Dias</button>
                                    <button type="button" class="btn btn-primary" onclick="updateChart('30d')">30 Dias</button>
                                    <button type="button" class="btn btn-outline-primary" onclick="updateChart('90d')">90 Dias</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Métodos de Pagamento -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Métodos de Pagamento</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentMethodsChart" height="300"></canvas>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Método</th>
                                        <th class="text-right">Qtd</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dashboardData['transactions']['payment_methods'] ?? [] as $method)
                                    <tr>
                                        <td>{{ ucfirst($method['method']) }}</td>
                                        <td class="text-right">{{ $method['count'] }}</td>
                                        <td class="text-right">{{ $method['formatted_total'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas e Atividade Recente -->
        <div class="row mt-4">
            <!-- Alertas -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Alertas Importantes</h3>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @forelse($dashboardData['alerts'] ?? [] as $alert)
                        <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show" role="alert">
                            <strong>{{ $alert['title'] }}</strong><br>
                            <small>{{ $alert['message'] }}</small>
                            @if(isset($alert['link']))
                            <br><a href="{{ $alert['link'] }}" class="alert-link">{{ $alert['action'] ?? 'Ver mais' }}</a>
                            @endif
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                        @empty
                        <p class="text-muted text-center">Nenhum alerta no momento</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Atividade Recente -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Atividade Recente</h3>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="timeline timeline-one-side">
                            @forelse($dashboardData['recent_activity'] ?? [] as $activity)
                            <div class="timeline-block">
                                <span class="timeline-step badge-{{ $activity['color'] ?? 'primary' }}">
                                    <i class="fas fa-{{ $activity['icon'] ?? 'circle' }}"></i>
                                </span>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-0">{{ $activity['title'] }}</h5>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</small>
                                    </div>
                                    <p class="text-sm mt-1 mb-0">{{ $activity['description'] }}</p>
                                    @if(isset($activity['link']))
                                    <a href="{{ $activity['link'] }}" class="text-primary text-sm">Ver detalhes →</a>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <p class="text-muted text-center">Nenhuma atividade recente</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance dos Checkouts -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Performance dos Checkouts</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Checkout</th>
                                        <th>Taxa de Conversão</th>
                                        <th>Total de Pedidos</th>
                                        <th>Receita Total</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dashboardData['performance']['checkout_performance'] ?? [] as $checkout)
                                    <tr>
                                        <td>{{ $checkout['name'] }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ $checkout['conversion_rate'] }}</span>
                                        </td>
                                        <td>{{ $checkout['total_orders'] }}</td>
                                        <td>R$ {{ number_format($checkout['total_revenue'], 2, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('user.checkout-builder.show', $checkout['id']) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Nenhum checkout criado ainda</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuração dos gráficos
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Receita
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($dashboardData['revenue']['daily_chart'] ?? []);

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueData.map(d => d.date),
            datasets: [{
                label: 'Receita Diária',
                data: revenueData.map(d => d.revenue),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Métodos de Pagamento
    const paymentCtx = document.getElementById('paymentMethodsChart').getContext('2d');
    const paymentData = @json($dashboardData['transactions']['payment_methods'] ?? []);

    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: paymentData.map(d => d.method),
            datasets: [{
                data: paymentData.map(d => d.total),
                backgroundColor: [
                    '#5e72e4',
                    '#2dce89',
                    '#fb6340',
                    '#f5365c',
                    '#ffd600'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});

// Funções auxiliares
function refreshDashboard() {
    window.location.reload();
}

function exportReport() {
    alert('Função de exportação será implementada');
}

function updateChart(period) {
    // Implementar atualização do gráfico via AJAX
    console.log('Atualizando para período:', period);
}

// Auto-refresh a cada 60 segundos
setInterval(function() {
    // Implementar refresh via AJAX dos dados
}, 60000);
</script>
@endpush

@endsection
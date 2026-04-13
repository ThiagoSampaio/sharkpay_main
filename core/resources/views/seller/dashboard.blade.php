@extends('userlayout')

@section('css')
<style>
.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.stat-card .stat-value {
    font-size: 2rem;
    font-weight: bold;
}
.stat-card .stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-top: 5px;
}
.chart-container {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}
.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}
</style>
@endsection

@section('content')
<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-8 col-7">
                    <h6 class="h2 d-inline-block mb-0">Dashboard de Vendas</h6>
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Seller Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 col-5 text-right">
                    <a href="{{route('seller.products.create')}}" class="btn btn-primary">
                        <i data-lucide="plus" style="width: 16px; height: 16px;"></i> Novo Produto
                    </a>
                    <a href="{{route('seller.withdrawals')}}" class="btn btn-success">
                        <i data-lucide="wallet" style="width: 16px; height: 16px;"></i> Solicitar Saque
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <!-- Notificações -->
    @if(count($notifications) > 0)
    <div class="row mb-4">
        <div class="col-12">
            @foreach($notifications as $notification)
            <div class="alert alert-{{$notification['type']}} alert-dismissible fade show" role="alert">
                <span class="alert-inner--icon"><i class="fas fa-info-circle"></i></span>
                <span class="alert-inner--text">{{$notification['message']}}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Métricas Principais -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value">R$ {{number_format($metrics['total_revenue'], 2, ',', '.')}}</div>
                <div class="stat-label">Receita Total</div>
                <div class="mt-3">
                    <span class="text-white-50">
                        <i class="fas fa-arrow-up"></i> 12% vs mês anterior
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="stat-value">R$ {{number_format($metrics['monthly_revenue'], 2, ',', '.')}}</div>
                <div class="stat-label">Receita Mensal</div>
                <div class="mt-3">
                    <span class="text-white-50">
                        <i class="fas fa-calendar"></i> {{date('F Y')}}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="stat-value">{{number_format($metrics['total_sales'])}}</div>
                <div class="stat-label">Total de Vendas</div>
                <div class="mt-3">
                    <span class="text-white-50">
                        <i class="fas fa-shopping-cart"></i> {{$metrics['monthly_sales']}} este mês
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="stat-value">{{$metrics['conversion_rate']}}%</div>
                <div class="stat-label">Taxa de Conversão</div>
                <div class="mt-3">
                    <span class="text-white-50">
                        <i class="fas fa-chart-line"></i> Média do mês
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Vendas -->
    <div class="row mt-4">
        <div class="col-xl-8">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Vendas dos Últimos 30 Dias</h3>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active">30 dias</button>
                        <button type="button" class="btn btn-sm btn-outline-primary">90 dias</button>
                        <button type="button" class="btn btn-sm btn-outline-primary">1 ano</button>
                    </div>
                </div>
                <canvas id="salesChart" height="80"></canvas>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="chart-container">
                <h3 class="mb-4">Resumo Financeiro</h3>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Saldo Disponível</span>
                        <span class="h4 mb-0 text-success">R$ {{number_format($financialSummary['available_balance'], 2, ',', '.')}}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Saldo Pendente</span>
                        <span class="h4 mb-0 text-warning">R$ {{number_format($financialSummary['pending_balance'], 2, ',', '.')}}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Total Sacado</span>
                        <span class="h4 mb-0">R$ {{number_format($financialSummary['total_withdrawn'], 2, ',', '.')}}</span>
                    </div>
                </div>
                <hr>
                <div class="text-center mt-4">
                    <small class="text-muted">Próximo pagamento: {{$financialSummary['next_payment_date']}}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Produtos e Vendas Recentes -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Top Produtos</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('seller.products')}}" class="btn btn-sm btn-primary">Ver todos</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Produto</th>
                                <th>Vendas</th>
                                <th>Receita</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            <tr>
                                <td>
                                    <div class="media align-items-center">
                                        @if($product->thumbnail)
                                        <img src="{{url('/')}}/asset/thumbnails/{{$product->thumbnail}}" class="avatar rounded-circle mr-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                        <div class="avatar rounded-circle mr-3 bg-primary" style="width: 40px; height: 40px;">
                                            <i data-lucide="package" style="width: 20px; height: 20px; color: white; margin: 10px;"></i>
                                        </div>
                                        @endif
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{$product->name}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$product->orders_count ?? 0}}</td>
                                <td>R$ {{number_format($product->amount * ($product->orders_count ?? 0), 2, ',', '.')}}</td>
                                <td>
                                    <a href="{{route('seller.products.edit', $product->id)}}" class="btn btn-sm btn-primary">
                                        <i data-lucide="edit" style="width: 14px; height: 14px;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Vendas Recentes</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('seller.reports.sales')}}" class="btn btn-sm btn-primary">Ver todas</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Cliente</th>
                                <th>Produto</th>
                                <th>Valor</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                            <tr>
                                <td>
                                    <span class="name mb-0 text-sm">{{$sale->user->first_name ?? 'Cliente'}}</span>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{$sale->product->name ?? 'Produto'}}</span>
                                </td>
                                <td>R$ {{number_format($sale->amount, 2, ',', '.')}}</td>
                                <td>{{$sale->created_at->format('d/m/Y H:i')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
// Initialize Lucide icons
lucide.createIcons();

// Sales Chart
var ctx = document.getElementById('salesChart').getContext('2d');
var salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($salesChart['labels'] ?? []),
        datasets: [{
            label: 'Vendas',
            data: @json($salesChart['sales'] ?? []),
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            yAxisID: 'y-sales',
        }, {
            label: 'Receita (R$)',
            data: @json($salesChart['revenue'] ?? []),
            borderColor: 'rgb(237, 100, 166)',
            backgroundColor: 'rgba(237, 100, 166, 0.1)',
            tension: 0.4,
            yAxisID: 'y-revenue',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            yAxes: [{
                id: 'y-sales',
                type: 'linear',
                display: true,
                position: 'left',
                scaleLabel: {
                    display: true,
                    labelString: 'Vendas'
                },
                ticks: {
                    beginAtZero: true
                }
            }, {
                id: 'y-revenue',
                type: 'linear',
                display: true,
                position: 'right',
                scaleLabel: {
                    display: true,
                    labelString: 'Receita (R$)'
                },
                gridLines: {
                    drawOnChartArea: false,
                },
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        },
        legend: {
            display: true,
            position: 'bottom'
        }
    }
});

// Auto refresh dashboard every 5 minutes
setInterval(function() {
    location.reload();
}, 300000);
</script>
@endsection
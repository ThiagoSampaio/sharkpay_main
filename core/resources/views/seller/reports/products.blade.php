@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-dark d-inline-block mb-0">Relatório de Produtos</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">Seller</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Relatório de Produtos</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('seller.reports.products') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data Inicial</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Data Final</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Métricas -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total de Produtos</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $metrics['total_products'] }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Produtos Ativos</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $metrics['active_products'] }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total de Vendas</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $metrics['total_sales'] }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Receita Total</h5>
                                <span class="h2 font-weight-bold mb-0">R$ {{ number_format($metrics['total_revenue'], 2, ',', '.') }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Performance de Produtos -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Performance dos Produtos</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Produto</th>
                                    <th>Vendas</th>
                                    <th>Receita</th>
                                    <th>Taxa de Conversão</th>
                                    <th>Taxa de Reembolso</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productPerformance as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="font-weight-600">{{ $product->name }}</div>
                                                    <div class="text-sm text-muted">{{ $product->cat->name ?? 'Sem categoria' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->orders_count }}</td>
                                        <td>R$ {{ number_format($product->revenue, 2, ',', '.') }}</td>
                                        <td>{{ number_format($product->conversion_rate, 1) }}%</td>
                                        <td>{{ number_format($product->refund_rate, 1) }}%</td>
                                        <td>
                                            <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Nenhum produto encontrado</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produtos Mais Vendidos -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Top 10 Produtos Mais Vendidos</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="topProductsChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    const ctx = document.getElementById('topProductsChart').getContext('2d');
    const topProductsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('name')),
            datasets: [{
                label: 'Vendas',
                data: @json($topProducts->pluck('orders_count')),
                backgroundColor: 'rgba(94, 114, 228, 0.8)',
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
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
@endsection

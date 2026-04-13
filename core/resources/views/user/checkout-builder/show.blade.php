@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-8">
                        <h1 class="display-4 text-white">{{ $checkout->name }}</h1>
                        <p class="text-light">{{ $checkout->description ?? 'Checkout personalizado para maximizar conversões' }}</p>
                        <span class="badge badge-{{ $checkout->status == 'active' ? 'success' : ($checkout->status == 'inactive' ? 'warning' : 'secondary') }} badge-lg">
                            {{ ucfirst($checkout->status) }}
                        </span>
                    </div>
                    <div class="col-lg-4 text-right">
                        <a href="{{ route('user.checkout-builder.edit', $checkout->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ $checkout->checkout_url }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-external-link-alt"></i> Abrir Checkout
                        </a>
                        <button onclick="copyCheckoutUrl()" class="btn btn-sm btn-success">
                            <i class="fas fa-copy"></i> Copiar URL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <!-- Estatísticas Gerais -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total de Visitas</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($checkout->total_visits) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total de Pedidos</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($checkout->total_orders) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Taxa de Conversão</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $checkout->conversion_rate_formatted ?? '0%' }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                    <i class="fas fa-percentage"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Receita Total</h5>
                                <span class="h2 font-weight-bold mb-0">R$ {{ number_format($checkout->total_revenue, 2, ',', '.') }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-purple text-white rounded-circle shadow">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Gráfico de Performance -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Performance nos Últimos 30 Dias</h3>
                            </div>
                            <div class="col text-right">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary active" data-period="30d">30 Dias</button>
                                    <button type="button" class="btn btn-outline-primary" data-period="7d">7 Dias</button>
                                    <button type="button" class="btn btn-outline-primary" data-period="today">Hoje</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="performanceChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detalhes da Configuração -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Configuração Atual</h3>
                    </div>
                    <div class="card-body">
                        <h5>Métodos de Pagamento</h5>
                        <div class="mb-3">
                            @foreach($checkout->payment_methods ?? [] as $method => $enabled)
                                @if($enabled)
                                <span class="badge badge-primary">{{ ucfirst(str_replace('_', ' ', $method)) }}</span>
                                @endif
                            @endforeach
                        </div>

                        <h5>Funil de Vendas</h5>
                        <ul class="list-unstyled">
                            <li><strong>Produto Principal:</strong> {{ $checkout->getMainProduct()->name ?? 'Não definido' }}</li>
                            @if($checkout->hasUpsells())
                            <li><strong>Upsells:</strong> {{ count($checkout->upsell_products ?? []) }} produtos</li>
                            @endif
                            @if($checkout->hasDownsells())
                            <li><strong>Downsells:</strong> {{ count($checkout->downsell_products ?? []) }} produtos</li>
                            @endif
                        </ul>

                        <h5 class="mt-3">Tema</h5>
                        <div class="d-flex align-items-center mb-2">
                            <div style="width: 30px; height: 30px; background-color: {{ $checkout->theme_config['primary_color'] ?? '#007bff' }}; border-radius: 4px; margin-right: 10px;"></div>
                            <span>Cor Primária</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div style="width: 30px; height: 30px; background-color: {{ $checkout->theme_config['secondary_color'] ?? '#6c757d' }}; border-radius: 4px; margin-right: 10px;"></div>
                            <span>Cor Secundária</span>
                        </div>

                        @if(isset($checkout->abandoned_cart_config['enabled']) && $checkout->abandoned_cart_config['enabled'])
                        <h5 class="mt-3">Carrinho Abandonado</h5>
                        <p class="text-sm">
                            Ativado - {{ $checkout->abandoned_cart_config['time_minutes'] ?? 30 }} minutos<br>
                            Desconto: {{ $checkout->abandoned_cart_config['discount_percentage'] ?? 0 }}%
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabelas de Dados -->
        <div class="row mt-4">
            <!-- Transações Recentes -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Transações Recentes</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions ?? [] as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d/m H:i') }}</td>
                                        <td>{{ $transaction->customer_name }}</td>
                                        <td>R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Nenhuma transação ainda</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Análise de Conversão -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Análise de Conversão</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Métrica</th>
                                        <th class="text-right">Valor</th>
                                        <th class="text-right">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Visitantes únicos</td>
                                        <td class="text-right">{{ number_format($metrics['unique_visitors'] ?? 0) }}</td>
                                        <td class="text-right">100%</td>
                                    </tr>
                                    <tr>
                                        <td>Início de checkout</td>
                                        <td class="text-right">{{ number_format($metrics['checkout_starts'] ?? 0) }}</td>
                                        <td class="text-right">{{ number_format(($metrics['checkout_start_rate'] ?? 0), 1) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Formulário completo</td>
                                        <td class="text-right">{{ number_format($metrics['form_completions'] ?? 0) }}</td>
                                        <td class="text-right">{{ number_format(($metrics['form_completion_rate'] ?? 0), 1) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Pagamento processado</td>
                                        <td class="text-right">{{ number_format($metrics['payments_processed'] ?? 0) }}</td>
                                        <td class="text-right">{{ number_format(($metrics['payment_success_rate'] ?? 0), 1) }}%</td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>Conversões totais</td>
                                        <td class="text-right">{{ number_format($checkout->total_orders) }}</td>
                                        <td class="text-right">{{ $checkout->conversion_rate_formatted }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Ações Rápidas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <button onclick="duplicateCheckout()" class="btn btn-info btn-block">
                                    <i class="fas fa-copy"></i> Duplicar Checkout
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button onclick="resetStatistics()" class="btn btn-warning btn-block">
                                    <i class="fas fa-redo"></i> Resetar Estatísticas
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button onclick="exportData()" class="btn btn-success btn-block">
                                    <i class="fas fa-download"></i> Exportar Dados
                                </button>
                            </div>
                            <div class="col-md-3">
                                @if($checkout->status == 'active')
                                <button onclick="toggleStatus('deactivate')" class="btn btn-danger btn-block">
                                    <i class="fas fa-pause"></i> Desativar
                                </button>
                                @else
                                <button onclick="toggleStatus('activate')" class="btn btn-success btn-block">
                                    <i class="fas fa-play"></i> Ativar
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Embed Code -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Código de Integração</h3>
                    </div>
                    <div class="card-body">
                        <p>Use os códigos abaixo para integrar este checkout em seu site:</p>
                        
                        <h5>Link Direto</h5>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="checkout-url" value="{{ $checkout->checkout_url }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" onclick="copyToClipboard('checkout-url')">
                                    <i class="fas fa-copy"></i> Copiar
                                </button>
                            </div>
                        </div>

                        <h5>Botão HTML</h5>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" readonly id="html-button"><a href="{{ $checkout->checkout_url }}" class="checkout-button" target="_blank">
  Comprar Agora
</a></textarea>
                            <button class="btn btn-sm btn-outline-secondary mt-2" onclick="copyToClipboard('html-button')">
                                <i class="fas fa-copy"></i> Copiar Código
                            </button>
                        </div>

                        <h5>iframe</h5>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" readonly id="iframe-code"><iframe src="{{ $checkout->checkout_url }}" 
        width="100%" 
        height="600" 
        frameborder="0">
</iframe></textarea>
                            <button class="btn btn-sm btn-outline-secondary mt-2" onclick="copyToClipboard('iframe-code')">
                                <i class="fas fa-copy"></i> Copiar Código
                            </button>
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
// Gráfico de Performance
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const performanceData = @json($performanceData ?? []);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: performanceData.map(d => d.date),
            datasets: [{
                label: 'Visitas',
                data: performanceData.map(d => d.visits),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                yAxisID: 'y',
            }, {
                label: 'Conversões',
                data: performanceData.map(d => d.conversions),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                yAxisID: 'y1',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            }
        }
    });
});

// Funções auxiliares
function copyCheckoutUrl() {
    copyToClipboard('checkout-url');
    alert('URL copiada para a área de transferência!');
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    element.setSelectionRange(0, 99999);
    document.execCommand('copy');
}

function duplicateCheckout() {
    if (confirm('Deseja duplicar este checkout?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("user.checkout-builder.duplicate", $checkout->id) }}';
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

function toggleStatus(action) {
    if (confirm(`Deseja realmente ${action === 'activate' ? 'ativar' : 'desativar'} este checkout?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/checkout-builder') }}/{{ $checkout->id }}/${action}`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

function resetStatistics() {
    if (confirm('Tem certeza que deseja resetar as estatísticas? Esta ação não pode ser desfeita.')) {
        // Implementar reset de estatísticas via AJAX
        alert('Função será implementada');
    }
}

function exportData() {
    window.location.href = '{{ route("user.checkout-builder.export", $checkout->id) }}';
}
</script>
@endpush

@endsection
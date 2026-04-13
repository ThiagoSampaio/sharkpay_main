@extends('userlayout')

@section('css')
<style>
    .seller-analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }

    .seller-analytics-card {
        border: 1px solid rgba(123, 22, 244, 0.1);
        border-radius: 24px;
        background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(247,244,255,0.92));
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
    }

    .seller-analytics-card__body {
        padding: 1.35rem;
    }

    .seller-analytics-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.4rem 0.72rem;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--sharkpay-purple-dark);
        background: rgba(123, 22, 244, 0.08);
    }

    .seller-analytics-value {
        margin: 0.9rem 0 0.25rem;
        font-size: clamp(1.8rem, 2.2vw, 2.35rem);
        font-weight: 700;
        color: #111827;
        line-height: 1.1;
    }

    .seller-analytics-label {
        color: #667085;
        font-size: 0.96rem;
        font-weight: 500;
    }

    .seller-analytics-change {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.9rem;
        color: #5b21b6;
        font-size: 0.88rem;
        font-weight: 600;
    }

    .seller-analytics-surface {
        border: 1px solid rgba(17, 24, 39, 0.06);
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .seller-analytics-surface__header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.35rem 1.35rem 0;
    }

    .seller-analytics-surface__title {
        margin: 0;
        color: #111827;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .seller-analytics-surface__copy {
        margin: 0.35rem 0 0;
        color: #667085;
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .seller-analytics-surface__body {
        padding: 1.1rem 1.35rem 1.35rem;
    }

    .seller-analytics-chart {
        position: relative;
        min-height: 300px;
    }

    .seller-analytics-list {
        display: grid;
        gap: 0.9rem;
    }

    .seller-analytics-list__item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.95rem 1rem;
        border-radius: 18px;
        background: rgba(248, 250, 252, 0.95);
        border: 1px solid rgba(17, 24, 39, 0.05);
    }

    .seller-analytics-list__name {
        margin: 0;
        color: #111827;
        font-weight: 600;
    }

    .seller-analytics-list__meta {
        margin: 0.2rem 0 0;
        color: #667085;
        font-size: 0.88rem;
    }

    .seller-analytics-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.38rem 0.7rem;
        border-radius: 999px;
        background: rgba(123, 22, 244, 0.08);
        color: var(--sharkpay-purple-dark);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .seller-analytics-progress {
        height: 10px;
        border-radius: 999px;
        background: rgba(226, 232, 240, 0.9);
        overflow: hidden;
    }

    .seller-analytics-progress > span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(135deg, var(--sharkpay-purple-dark), var(--sharkpay-orange));
    }
</style>
@endsection

@section('content')
<div class="container-fluid mt--6">
    <div class="panel-page-hero mb-4">
        <span class="panel-page-hero__eyebrow"><i data-lucide="line-chart" style="width: 14px; height: 14px;"></i> Seller analytics</span>
        <h1 class="panel-page-hero__title">Leia o desempenho comercial do seller com foco em receita, pedidos, clientes e ritmo de crescimento.</h1>
        <p class="panel-page-hero__copy">Use esta visao para entender o comportamento do periodo, comparar com a janela anterior e identificar quais produtos estao sustentando a operacao. Os indicadores abaixo foram reorganizados para leitura executiva e acompanhamento diario.</p>
        <div class="panel-page-hero__actions">
            <form method="GET" action="{{ route('seller.analytics') }}" class="d-flex flex-wrap align-items-center" style="gap: .75rem;">
                <select name="period" class="form-control" style="min-width: 180px;">
                    <option value="7d" {{ $period === '7d' ? 'selected' : '' }}>Ultimos 7 dias</option>
                    <option value="30d" {{ $period === '30d' ? 'selected' : '' }}>Ultimos 30 dias</option>
                    <option value="90d" {{ $period === '90d' ? 'selected' : '' }}>Ultimos 90 dias</option>
                    <option value="1y" {{ $period === '1y' ? 'selected' : '' }}>Ultimos 12 meses</option>
                </select>
                <button type="submit" class="btn btn-primary btn-modern btn-primary-modern">
                    <i data-lucide="filter" style="width: 16px; height: 16px;"></i> Atualizar periodo
                </button>
                <a href="{{ route('seller.reports.sales') }}" class="btn btn-neutral btn-modern">
                    <i data-lucide="file-text" style="width: 16px; height: 16px;"></i> Ver relatorio de vendas
                </a>
            </form>
        </div>
        <div class="panel-page-hero__meta">
            <span><strong>{{ number_format($metrics['orders'] ?? 0) }}</strong> pedidos no periodo</span>
            <span><strong>{{ number_format($metrics['customers'] ?? 0) }}</strong> clientes unicos</span>
            <span><strong>R$ {{ number_format($metrics['avg_order_value'] ?? 0, 2, ',', '.') }}</strong> ticket medio</span>
        </div>
    </div>

    <div class="panel-note mb-4">
        <i data-lucide="sparkles" style="width: 18px; height: 18px;"></i>
        <div>
            <strong>Leitura rapida do periodo</strong>
            <p>O comparativo abaixo usa a mesma janela imediatamente anterior para mostrar se receita, pedidos e base de clientes estao acelerando ou desacelerando.</p>
        </div>
    </div>

    <div class="seller-analytics-grid mb-4">
        <div class="seller-analytics-card">
            <div class="seller-analytics-card__body">
                <span class="seller-analytics-kicker"><i data-lucide="wallet" style="width: 14px; height: 14px;"></i> Receita</span>
                <div class="seller-analytics-value">R$ {{ number_format($metrics['revenue'] ?? 0, 2, ',', '.') }}</div>
                <div class="seller-analytics-label">Volume consolidado no periodo selecionado.</div>
                <div class="seller-analytics-change"><i data-lucide="trending-up" style="width: 14px; height: 14px;"></i> {{ number_format($comparison['revenue_growth'] ?? 0, 1, ',', '.') }}% vs periodo anterior</div>
            </div>
        </div>
        <div class="seller-analytics-card">
            <div class="seller-analytics-card__body">
                <span class="seller-analytics-kicker"><i data-lucide="shopping-bag" style="width: 14px; height: 14px;"></i> Pedidos</span>
                <div class="seller-analytics-value">{{ number_format($metrics['orders'] ?? 0) }}</div>
                <div class="seller-analytics-label">Transacoes e compras vinculadas ao seller.</div>
                <div class="seller-analytics-change"><i data-lucide="bar-chart-3" style="width: 14px; height: 14px;"></i> {{ number_format($comparison['orders_growth'] ?? 0, 1, ',', '.') }}% de variacao</div>
            </div>
        </div>
        <div class="seller-analytics-card">
            <div class="seller-analytics-card__body">
                <span class="seller-analytics-kicker"><i data-lucide="users" style="width: 14px; height: 14px;"></i> Clientes</span>
                <div class="seller-analytics-value">{{ number_format($metrics['customers'] ?? 0) }}</div>
                <div class="seller-analytics-label">Compradores distintos dentro da janela analisada.</div>
                <div class="seller-analytics-change"><i data-lucide="user-plus" style="width: 14px; height: 14px;"></i> {{ number_format($comparison['customers_growth'] ?? 0, 1, ',', '.') }}% de crescimento</div>
            </div>
        </div>
        <div class="seller-analytics-card">
            <div class="seller-analytics-card__body">
                <span class="seller-analytics-kicker"><i data-lucide="receipt" style="width: 14px; height: 14px;"></i> Ticket medio</span>
                <div class="seller-analytics-value">R$ {{ number_format($metrics['avg_order_value'] ?? 0, 2, ',', '.') }}</div>
                <div class="seller-analytics-label">Valor medio por pedido concluido no periodo.</div>
                <div class="seller-analytics-change"><i data-lucide="percent" style="width: 14px; height: 14px;"></i> Conversao {{ number_format($metrics['conversion_rate'] ?? 0, 2, ',', '.') }}%</div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-8 mb-4 mb-xl-0">
            <div class="seller-analytics-surface h-100">
                <div class="seller-analytics-surface__header">
                    <div>
                        <h3 class="seller-analytics-surface__title">Receita ao longo do tempo</h3>
                        <p class="seller-analytics-surface__copy">Acompanhe como o valor recebido evolui dentro do periodo filtrado. Use esse grafico para identificar pico de campanhas, sazonalidade e desaceleracao.</p>
                    </div>
                    <span class="seller-analytics-pill">Financeiro</span>
                </div>
                <div class="seller-analytics-surface__body">
                    <div class="seller-analytics-chart">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="seller-analytics-surface h-100">
                <div class="seller-analytics-surface__header">
                    <div>
                        <h3 class="seller-analytics-surface__title">Radar operacional</h3>
                        <p class="seller-analytics-surface__copy">Resumo objetivo dos indicadores que mais afetam a capacidade de crescimento do seller.</p>
                    </div>
                    <span class="seller-analytics-pill">Visao executiva</span>
                </div>
                <div class="seller-analytics-surface__body">
                    <div class="seller-analytics-list">
                        <div class="seller-analytics-list__item">
                            <div>
                                <p class="seller-analytics-list__name">Fontes de trafego</p>
                                <p class="seller-analytics-list__meta">Distribuicao estimada entre canais ativos.</p>
                            </div>
                            <strong class="text-dark">{{ array_sum($charts['traffic_sources'] ?? []) }}%</strong>
                        </div>
                        @foreach(($charts['traffic_sources'] ?? []) as $source => $share)
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-capitalize text-muted font-weight-600">{{ str_replace('_', ' ', $source) }}</span>
                                    <span class="text-dark font-weight-700">{{ $share }}%</span>
                                </div>
                                <div class="seller-analytics-progress"><span style="width: {{ min(100, $share) }}%;"></span></div>
                            </div>
                        @endforeach
                        <div class="seller-analytics-list__item">
                            <div>
                                <p class="seller-analytics-list__name">Taxa de reembolso</p>
                                <p class="seller-analytics-list__meta">Indicador de risco para monitoramento comercial.</p>
                            </div>
                            <span class="seller-analytics-pill">{{ number_format($metrics['refund_rate'] ?? 0, 2, ',', '.') }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-7 mb-4 mb-xl-0">
            <div class="seller-analytics-surface h-100">
                <div class="seller-analytics-surface__header">
                    <div>
                        <h3 class="seller-analytics-surface__title">Pedidos por intervalo</h3>
                        <p class="seller-analytics-surface__copy">Volume de pedidos no mesmo recorte temporal para cruzar cadencia de compras com a curva de receita.</p>
                    </div>
                    <span class="seller-analytics-pill">Comercial</span>
                </div>
                <div class="seller-analytics-surface__body">
                    <div class="seller-analytics-chart">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="seller-analytics-surface h-100">
                <div class="seller-analytics-surface__header">
                    <div>
                        <h3 class="seller-analytics-surface__title">Produtos com maior tracao</h3>
                        <p class="seller-analytics-surface__copy">Ranking rapido dos itens que mais sustentaram pedidos e receita no periodo atual.</p>
                    </div>
                    <a href="{{ route('seller.products') }}" class="btn btn-sm btn-neutral btn-modern">Abrir catalogo</a>
                </div>
                <div class="seller-analytics-surface__body">
                    <div class="seller-analytics-list">
                        @forelse(($charts['top_products'] ?? []) as $product)
                            <div class="seller-analytics-list__item">
                                <div>
                                    <p class="seller-analytics-list__name">{{ $product->name }}</p>
                                    <p class="seller-analytics-list__meta">{{ $product->orders_count }} pedido(s) no periodo</p>
                                </div>
                                <div class="text-right">
                                    <strong class="d-block text-dark">R$ {{ number_format($product->analytics_revenue ?? 0, 2, ',', '.') }}</strong>
                                    <span class="text-muted small">Receita estimada</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-state-icon"><i data-lucide="package-search"></i></div>
                                <h3 class="empty-state-title">Nenhum produto com tracao recente</h3>
                                <p class="empty-state-text">Quando houver pedidos dentro do periodo filtrado, este ranking mostrara quais itens estao puxando a operacao.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const sharedChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: {
                display: false,
            },
        },
        scales: {
            x: {
                grid: {
                    display: false,
                },
                ticks: {
                    color: '#667085',
                },
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(148, 163, 184, 0.16)',
                },
                ticks: {
                    color: '#667085',
                },
            },
        },
    };

    new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($charts['revenue_chart']['labels'] ?? []),
            datasets: [{
                label: 'Receita',
                data: @json($charts['revenue_chart']['data'] ?? []),
                borderColor: '#6d28d9',
                backgroundColor: 'rgba(109, 40, 217, 0.12)',
                pointBackgroundColor: '#6d28d9',
                pointBorderWidth: 0,
                fill: true,
                tension: 0.35,
            }],
        },
        options: sharedChartOptions,
    });

    new Chart(document.getElementById('ordersChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($charts['orders_chart']['labels'] ?? []),
            datasets: [{
                label: 'Pedidos',
                data: @json($charts['orders_chart']['data'] ?? []),
                backgroundColor: 'rgba(245, 138, 0, 0.82)',
                borderRadius: 12,
                borderSkipped: false,
                maxBarThickness: 28,
            }],
        },
        options: sharedChartOptions,
    });
</script>
@endpush
@endsection

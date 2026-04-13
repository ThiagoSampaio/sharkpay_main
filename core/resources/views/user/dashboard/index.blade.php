@extends('userlayout')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/asset/dashboard/css/dashboard-modern.css">
<style>
.container-fluid.mt--6 {
    background: transparent;
  min-height: calc(100vh - 200px);
  margin-top: -6rem !important;
  padding-top: 6rem;
}

.content-wrapper {
    padding-bottom: 2rem;
}

.dashboard-hero {
    position: relative;
    display: grid;
    grid-template-columns: minmax(0, 1.45fr) minmax(320px, .9fr);
    gap: 1.35rem;
    overflow: hidden;
    background:
        radial-gradient(circle at top right, rgba(255, 255, 255, 0.75), transparent 30%),
        linear-gradient(135deg, rgba(123, 22, 244, 0.1), rgba(245, 138, 0, 0.08));
    border: 1px solid rgba(123, 22, 244, 0.08);
    border-radius: 28px;
    padding: 2rem;
    margin-bottom: 1.75rem;
    box-shadow: 0 20px 38px rgba(29, 35, 59, 0.06);
}

.dashboard-hero::before {
    content: "";
    position: absolute;
    inset: auto auto -90px -90px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(123, 22, 244, 0.12), transparent 70%);
}

.dashboard-hero::after {
    content: "";
    position: absolute;
    right: -70px;
    top: -85px;
    width: 230px;
    height: 230px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.62), transparent 65%);
}

.dashboard-hero__content,
.dashboard-hero__summary {
    position: relative;
    z-index: 1;
}

.dashboard-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .45rem .8rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.7);
    color: #6522d5;
    font-size: .74rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.dashboard-hero__title {
    margin: 1rem 0 .55rem;
    font-size: 2rem;
    font-weight: 800;
    color: #1c2340;
    letter-spacing: -.03em;
}

.dashboard-hero__copy {
    max-width: 700px;
    color: #667085;
    line-height: 1.75;
    margin: 0;
}

.dashboard-hero__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: .85rem;
    margin-top: 1.35rem;
}

.dashboard-hero__stat {
    padding: .95rem 1rem;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.72);
    border: 1px solid rgba(123, 22, 244, 0.08);
    backdrop-filter: blur(8px);
}

.dashboard-hero__stat-label {
    display: block;
    margin-bottom: .35rem;
    color: #8c93a8;
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.dashboard-hero__stat-value {
    display: block;
    color: #1c2340;
    font-size: 1.12rem;
    font-weight: 800;
}

.dashboard-hero__pills {
    display: flex;
    flex-wrap: wrap;
    gap: .65rem;
    margin-top: 1rem;
}

.dashboard-hero__pill {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    min-height: 34px;
    padding: 0 .8rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.72);
    border: 1px solid rgba(123, 22, 244, 0.08);
    color: #5d0fd3;
    font-size: .78rem;
    font-weight: 700;
}

.dashboard-hero__actions {
    display: flex;
    gap: .85rem;
    flex-wrap: wrap;
    margin-top: 1.35rem;
}

.dashboard-hero__btn {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    min-height: 2.95rem;
    padding: 0 .95rem;
    border-radius: 14px;
    border: 1px solid rgba(123, 22, 244, 0.1);
    background: #fff;
    color: #5d0fd3;
    font-weight: 700;
    transition: all .2s ease;
}

.dashboard-hero__btn:hover {
    text-decoration: none;
    color: #de7600;
    transform: translateY(-1px);
    box-shadow: 0 10px 22px rgba(123, 22, 244, 0.08);
}

.dashboard-spotlight {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    height: 100%;
    padding: 1.25rem;
    border-radius: 24px;
    background: rgba(255, 255, 255, 0.82);
    border: 1px solid rgba(255, 255, 255, 0.65);
    box-shadow: inset 0 1px 0 rgba(255,255,255,.45);
    backdrop-filter: blur(10px);
}

.dashboard-spotlight__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.dashboard-spotlight__eyebrow {
    display: block;
    color: #8c93a8;
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.dashboard-spotlight__title {
    display: block;
    margin-top: .28rem;
    color: #1c2340;
    font-size: 1.2rem;
    font-weight: 800;
    letter-spacing: -.02em;
}

.dashboard-spotlight__chip {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    min-height: 36px;
    padding: 0 .85rem;
    border-radius: 999px;
    background: #f4efff;
    color: #5d0fd3;
    font-size: .76rem;
    font-weight: 800;
}

.dashboard-spotlight__balance {
    padding: 1rem 1.05rem;
    border-radius: 20px;
    background: linear-gradient(135deg, #5d19ca 0%, #7b16f4 56%, #f58a00 180%);
    color: #fff;
    box-shadow: 0 16px 28px rgba(91, 16, 200, 0.18);
}

.dashboard-spotlight__balance-label {
    display: block;
    color: rgba(255,255,255,.72);
    font-size: .74rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.dashboard-spotlight__balance-value {
    display: block;
    margin-top: .38rem;
    font-size: 1.85rem;
    font-weight: 800;
    line-height: 1.1;
}

.dashboard-spotlight__meta {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: .8rem;
}

.dashboard-spotlight__meta-card {
    padding: .9rem 1rem;
    border-radius: 18px;
    background: #f8f9fd;
    border: 1px solid rgba(123, 22, 244, 0.06);
}

.dashboard-spotlight__meta-card strong {
    display: block;
    color: #1c2340;
    font-size: 1rem;
    font-weight: 800;
}

.dashboard-spotlight__meta-card span {
    display: block;
    margin-top: .25rem;
    color: #8c93a8;
    font-size: .76rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.dashboard-spotlight__actions {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: .75rem;
}

.dashboard-spotlight__action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    min-height: 42px;
    padding: 0 .9rem;
    border-radius: 14px;
    background: #fff;
    border: 1px solid rgba(123, 22, 244, 0.1);
    color: #5d0fd3;
    font-size: .84rem;
    font-weight: 700;
    transition: all .2s ease;
}

.dashboard-spotlight__action:hover {
    color: #de7600;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 10px 22px rgba(123, 22, 244, 0.08);
}

.metric-card {
  position: relative;
  overflow: hidden;
  background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(252,252,255,0.98));
    border-radius: 18px;
  padding: 1.5rem;
    border: 1px solid rgba(123, 22, 244, 0.07);
  transition: all 0.3s ease;
  height: 100%;
    box-shadow: 0 10px 24px rgba(28, 35, 64, 0.04);
}

.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 28px rgba(28,35,64,0.07);
}

.metric-card::after {
    content: "";
    position: absolute;
    inset: auto -20px -20px auto;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(123, 22, 244, 0.08), transparent 70%);
}

.metric-card__header,
.metric-card__footer {
    position: relative;
    z-index: 1;
}

.metric-card__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}

.metric-card__caption {
    display: block;
    color: #8c93a8;
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.metric-value {
  font-size: 2rem;
  font-weight: 700;
    background: linear-gradient(135deg, #6522d5 0%, #f58a00 130%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 0.5rem;
}

.metric-label {
  color: #718096;
  font-size: 0.875rem;
    font-weight: 700;
    letter-spacing: 0.01em;
}

.metric-icon {
  width: 40px;
  height: 40px;
    background: linear-gradient(135deg, #f3ebff 0%, #fff4e6 100%);
    border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  float: right;
  margin-top: -10px;
}

.metric-icon svg {
  width: 24px;
  height: 24px;
    stroke: #7c3aed;
}

.metric-note {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    margin-top: 1rem;
    color: #7b16f4;
    font-size: .78rem;
    font-weight: 700;
}

.chart-container {
  background: white;
    border-radius: 20px;
  padding: 2rem;
    border: 1px solid rgba(123, 22, 244, 0.07);
    box-shadow: 0 10px 24px rgba(28, 35, 64, 0.04);
}

.section-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1a202c;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.section-title svg {
  width: 20px;
  height: 20px;
    stroke: #7c3aed;
}

.payment-method-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 0;
  border-bottom: 1px solid #f7fafc;
}

.payment-method-item:last-child {
  border-bottom: none;
}

.payment-method-label {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: #4a5568;
  font-size: 0.875rem;
}

.payment-method-value {
  font-weight: 600;
  color: #1a202c;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
}

.badge-success {
  background: #d4f4dd;
  color: #22c55e;
}

.badge-warning {
  background: #fef3c7;
  color: #f59e0b;
}

.badge-danger {
  background: #fee2e2;
  color: #ef4444;
}

.api-card {
    background: linear-gradient(135deg, #5d19ca 0%, #7b16f4 56%, #f58a00 180%);
    border-radius: 20px;
  padding: 2rem;
  color: white;
    box-shadow: 0 18px 34px rgba(91, 16, 200, 0.18);
}

.api-input-wrapper {
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 8px;
  padding: 0.75rem;
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.api-input {
  background: transparent;
  border: none;
  color: white;
  flex: 1;
  font-family: monospace;
  font-size: 0.875rem;
}

.api-input::placeholder {
  color: rgba(255,255,255,0.6);
}

.copy-btn {
  background: rgba(255,255,255,0.2);
  border: none;
  padding: 0.5rem;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s;
}

.copy-btn:hover {
  background: rgba(255,255,255,0.3);
}

.empty-state {
  text-align: center;
  padding: 3rem;
}

.empty-state svg {
  width: 80px;
  height: 80px;
  stroke: #cbd5e0;
  margin: 0 auto 1rem;
}

.table-modern {
  width: 100%;
}

.table-modern thead th {
  background: #f8fafc;
  color: #718096;
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  padding: 0.75rem;
  border-bottom: 2px solid #e2e8f0;
}

.table-modern tbody td {
  padding: 1rem;
  border-bottom: 1px solid #f7fafc;
  color: #1a202c;
  font-size: 0.875rem;
}

.info-card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  border: 1px solid #e2e8f0;
  text-align: center;
}

.info-value {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 0.5rem;
}

.info-label {
  color: #718096;
  font-size: 0.875rem;
}

/* Tab Switch Styles */
.tab-switch-container {
  display: flex;
  justify-content: center;
  margin-bottom: 2rem;
}

.tab-switch {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 16px;
  padding: 0.5rem;
  display: inline-flex;
  gap: 0.5rem;
    border: 1px solid rgba(123, 22, 244, 0.08);
    box-shadow: 0 10px 22px rgba(28,35,64,0.05);
}

.tab-btn {
  background: transparent;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: 500;
  color: #718096;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.tab-btn:hover {
    background: #f7f2ff;
}

.tab-btn.active {
    background: linear-gradient(135deg, #6522d5 0%, #7b16f4 100%);
  color: white;
    box-shadow: 0 10px 18px rgba(123, 22, 244, 0.18);
}

.tab-btn.active svg {
  stroke: white;
}

.tab-content {
  animation: fadeIn 0.3s ease;
}

/* Producer Dashboard Styles */
.producer-card {
  background: white;
    border-radius: 18px;
  padding: 1.5rem;
    border: 1px solid rgba(123, 22, 244, 0.07);
  height: 100%;
  transition: all 0.3s ease;
    box-shadow: 0 10px 24px rgba(28,35,64,0.04);
}

.producer-card:hover {
  transform: translateY(-2px);
    box-shadow: 0 14px 26px rgba(28,35,64,0.07);
}

.producer-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.producer-label {
  color: #718096;
  font-size: 0.875rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.producer-icon {
  width: 24px;
  height: 24px;
    stroke: #7c3aed;
  opacity: 0.6;
}

.producer-value {
  font-size: 2rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 0.5rem;
}

.producer-change {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.875rem;
  color: #718096;
}

.producer-change.positive {
  color: #22c55e;
}

.producer-change.negative {
  color: #ef4444;
}

.producer-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
  margin-top: 1.5rem;
}

.stat-item {
  text-align: center;
  padding: 1rem;
    background: #faf7ff;
    border-radius: 12px;
}

.stat-number {
  font-size: 1.5rem;
  font-weight: 700;
  color: #7c3aed;
  margin-bottom: 0.25rem;
}

.stat-label {
  font-size: 0.75rem;
  color: #718096;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.producer-list {
  margin-top: 1rem;
}

.producer-list .list-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 0;
  border-bottom: 1px solid #f7fafc;
}

.producer-list .list-item:last-child {
  border-bottom: none;
}

.producer-list .list-label {
  color: #718096;
  font-size: 0.875rem;
}

.producer-list .list-value {
  font-weight: 600;
  color: #1a202c;
}

.producer-chart {
  margin-top: 1.5rem;
  padding: 1rem;
    background: #faf7ff;
    border-radius: 12px;
}

.producer-cta {
  background: white;
    border-radius: 20px;
  padding: 3rem;
  text-align: center;
    border: 1px solid rgba(123, 22, 244, 0.07);
    box-shadow: 0 10px 24px rgba(28,35,64,0.04);
}

.producer-cta h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a202c;
  margin: 1rem 0;
}

.producer-cta p {
  color: #718096;
  margin-bottom: 1.5rem;
}

.producer-cta .btn {
    background: linear-gradient(135deg, #6522d5 0%, #7b16f4 100%);
  color: white;
  border: none;
  padding: 0.75rem 2rem;
  border-radius: 8px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
}

.producer-cta .btn:hover {
  transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(124, 58, 237, 0.22);
}

@media (max-width: 991.98px) {
    .dashboard-hero {
        grid-template-columns: 1fr;
        padding: 1.4rem 1.4rem;
    }

    .dashboard-hero__title {
        font-size: 1.7rem;
    }

    .dashboard-hero__grid,
    .dashboard-spotlight__meta,
    .dashboard-spotlight__actions {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767.98px) {
    .dashboard-hero__actions,
    .dashboard-hero__pills {
        flex-direction: column;
    }

    .dashboard-hero__grid {
        grid-template-columns: 1fr;
    }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
@stop

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        @php
            $approvalRate = $n_transactions > 0 ? ($n_paid / $n_transactions) * 100 : 0;
            $settlementProgress = $n_transactions_total > 0 ? ($pendingBalance / $n_transactions_total) * 100 : 0;
            $workspaceName = $user->business_name ?: trim($user->first_name.' '.$user->last_name);
        @endphp
        <div class="dashboard-hero">
            <div class="dashboard-hero__content">
                <span class="dashboard-hero__eyebrow">
                    <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                    Central de operacoes SharkPay
                </span>
                <h1 class="dashboard-hero__title">{{ $workspaceName }}, sua operação está pronta para crescer com mais contexto e menos ruído.</h1>
                <p class="dashboard-hero__copy">A área central agora prioriza leitura de negócio: saldo disponível, aprovação, liquidação pendente e atalhos operacionais aparecem primeiro para orientar decisão, não só exibir números.</p>

                <div class="dashboard-hero__grid">
                    <div class="dashboard-hero__stat">
                        <span class="dashboard-hero__stat-label">Aprovacao</span>
                        <strong class="dashboard-hero__stat-value">{{ number_format($approvalRate, 1, ',', '.') }}%</strong>
                    </div>
                    <div class="dashboard-hero__stat">
                        <span class="dashboard-hero__stat-label">Ticket medio</span>
                        <strong class="dashboard-hero__stat-value">R$ {{ number_format($n_avgticket, 2, ',', '.') }}</strong>
                    </div>
                    <div class="dashboard-hero__stat">
                        <span class="dashboard-hero__stat-label">Liquidação futura</span>
                        <strong class="dashboard-hero__stat-value">{{ number_format($settlementProgress, 1, ',', '.') }}%</strong>
                    </div>
                </div>

                <div class="dashboard-hero__pills">
                    <span class="dashboard-hero__pill"><i data-lucide="zap" style="width: 14px; height: 14px;"></i> PIX ativo</span>
                    <span class="dashboard-hero__pill"><i data-lucide="credit-card" style="width: 14px; height: 14px;"></i> Cartao monitorado</span>
                    <span class="dashboard-hero__pill"><i data-lucide="shield-check" style="width: 14px; height: 14px;"></i> Conta {{ $user->kyc_status == 0 ? 'em verificacao' : 'verificada' }}</span>
                </div>

                <div class="dashboard-hero__actions">
                    <a href="{{route('user.transactions')}}" class="dashboard-hero__btn">
                        <i data-lucide="receipt" style="width: 16px; height: 16px;"></i>
                        Ver transacoes
                    </a>
                    <a href="{{route('user.fund')}}" class="dashboard-hero__btn">
                        <i data-lucide="plus-circle" style="width: 16px; height: 16px;"></i>
                        Recarregar saldo
                    </a>
                    <a href="{{route('user.api')}}" class="dashboard-hero__btn">
                        <i data-lucide="key" style="width: 16px; height: 16px;"></i>
                        Gerenciar API
                    </a>
                </div>
            </div>

            <div class="dashboard-hero__summary">
                <div class="dashboard-spotlight">
                    <div class="dashboard-spotlight__top">
                        <div>
                            <span class="dashboard-spotlight__eyebrow">Resumo executivo</span>
                            <span class="dashboard-spotlight__title">Visao de caixa</span>
                        </div>
                        <span class="dashboard-spotlight__chip">
                            <i data-lucide="activity" style="width: 14px; height: 14px;"></i>
                            Online
                        </span>
                    </div>

                    <div class="dashboard-spotlight__balance">
                        <span class="dashboard-spotlight__balance-label">Saldo disponivel</span>
                        <strong class="dashboard-spotlight__balance-value">{{$currency->name}} {{number_format($user->balance, 2, ',', '.')}}</strong>
                    </div>

                    <div class="dashboard-spotlight__meta">
                        <div class="dashboard-spotlight__meta-card">
                            <strong>{{$currency->name}} {{number_format($pendingBalance, 2, ',', '.')}}</strong>
                            <span>Saldo bloqueado</span>
                        </div>
                        <div class="dashboard-spotlight__meta-card">
                            <strong>{{date('d/m/Y', strtotime($set->next_settlement))}}</strong>
                            <span>Proxima liquidacao</span>
                        </div>
                    </div>

                    <div class="dashboard-spotlight__actions">
                        <a href="{{route('user.withdraw')}}" class="dashboard-spotlight__action">
                            <i data-lucide="arrow-down-circle" style="width: 15px; height: 15px;"></i>
                            Saques
                        </a>
                        <a href="{{route('user.compliance')}}" class="dashboard-spotlight__action">
                            <i data-lucide="badge-check" style="width: 15px; height: 15px;"></i>
                            {{ $user->kyc_status == 0 ? 'Verificar conta' : 'Conta ativa' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Switch -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="tab-switch-container">
                    <div class="tab-switch">
                        <button class="tab-btn active" data-tab="gateway">
                            <i data-lucide="credit-card" style="width: 18px; height: 18px;"></i>
                            Gateway de Pagamento
                        </button>
                        <button class="tab-btn" data-tab="producer">
                            <i data-lucide="package" style="width: 18px; height: 18px;"></i>
                            Produtor Digital
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gateway Tab Content -->
        <div id="gateway-tab" class="tab-content active">
        <!-- Main Metrics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card">
                    <div class="metric-card__header">
                        <div>
                            <span class="metric-card__caption">Movimento</span>
                            <div class="metric-value">{{number_format($n_transactions)}}</div>
                            <div class="metric-label">{{$lang["home_trasactions_number"]}}</div>
                        </div>
                        <div class="metric-icon">
                            <i data-lucide="trending-up"></i>
                        </div>
                    </div>
                    <div class="metric-note">
                        <i data-lucide="check-circle-2" style="width: 14px; height: 14px;"></i>
                        {{$n_paid}} aprovadas no periodo
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card">
                    <div class="metric-card__header">
                        <div>
                            <span class="metric-card__caption">Qualidade de venda</span>
                            <div class="metric-value">R$ {{number_format($n_avgticket, 2, ",", ".")}}</div>
                            <div class="metric-label">{{$lang["home_avg_ticket"]}}</div>
                        </div>
                        <div class="metric-icon">
                            <i data-lucide="shopping-cart"></i>
                        </div>
                    </div>
                    <div class="metric-note">
                        <i data-lucide="sparkline" style="width: 14px; height: 14px;"></i>
                        Ticket medio da operacao atual
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card">
                    <div class="metric-card__header">
                        <div>
                            <span class="metric-card__caption">Volume processado</span>
                            <div class="metric-value">R$ {{number_format($n_transactions_total, 2, ",", ".")}}</div>
                            <div class="metric-label">{{$lang["home_transactions_volume"]}}</div>
                        </div>
                        <div class="metric-icon">
                            <i data-lucide="dollar-sign"></i>
                        </div>
                    </div>
                    <div class="metric-note">
                        <i data-lucide="banknote" style="width: 14px; height: 14px;"></i>
                        Base para repasses e conciliacao
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card">
                    <div class="metric-card__header">
                        <div>
                            <span class="metric-card__caption">Receita SharkPay</span>
                            <div class="metric-value">{{$currency->name}} {{number_format($revenue, 2, ",", ".")}}</div>
                            <div class="metric-label">{{$lang["revenue"]}}</div>
                        </div>
                        <div class="metric-icon">
                            <i data-lucide="wallet"></i>
                        </div>
                    </div>
                    <div class="metric-note">
                        <i data-lucide="shield-check" style="width: 14px; height: 14px;"></i>
                        Receita consolidada da conta
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Details -->
        <div class="row mb-4">
            <!-- Earning Chart -->
            <div class="col-lg-8 mb-3">
                <div class="chart-container">
                    <h4 class="section-title">
                        <i data-lucide="bar-chart-2"></i>
                        {{$lang["earning_log"]}}
                    </h4>
                    @if(count($history)>0)
                        <canvas id="myChart" height="80"></canvas>
                    @else
                        <div class="empty-state">
                            <i data-lucide="inbox"></i>
                            <h5 class="text-muted">{{$lang["no_earning_history"]}}</h5>
                            <p class="text-muted small">{{$lang["we_couldnt_find_any_log_to_this_account"]}}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Transaction Status -->
            <div class="col-lg-4 mb-3">
                <div class="chart-container">
                    <h4 class="section-title">
                        <i data-lucide="pie-chart"></i>
                        {{$lang["home_transactions_by_status"]}}
                    </h4>
                    <div id="chart-payment-div" style="height: 200px; margin: 0 auto;"></div>
                    <div class="mt-3">
                        <div class="payment-method-item">
                            <span class="payment-method-label">
                                <span class="status-badge badge-success">{{$lang["home_paid"]}}</span>
                            </span>
                            <span class="payment-method-value">{{$n_paid}}</span>
                        </div>
                        <div class="payment-method-item">
                            <span class="payment-method-label">
                                <span class="status-badge badge-warning">{{$lang["home_waiting_payment"]}}</span>
                            </span>
                            <span class="payment-method-value">{{$n_pending}}</span>
                        </div>
                        <div class="payment-method-item">
                            <span class="payment-method-label">
                                <span class="status-badge badge-danger">{{$lang["home_defaulter"]}}</span>
                            </span>
                            <span class="payment-method-value">{{$n_defaulter}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="row mb-4">
            <div class="col-lg-4 mb-3">
                <div class="chart-container">
                    <h4 class="section-title">
                        <i data-lucide="credit-card"></i>
                        {{$lang["home_payment_methods"]}}
                    </h4>
                    <div class="payment-method-item">
                        <span class="payment-method-label">
                            <i data-lucide="zap" style="width: 16px; height: 16px; stroke: #7c3aed;"></i>
                            {{$lang["home_pix"]}}
                        </span>
                        <span class="payment-method-value">R$ {{number_format($n_transactions_pix, 2, ",", ".")}}</span>
                    </div>
                    <div class="payment-method-item">
                        <span class="payment-method-label">
                            <i data-lucide="credit-card" style="width: 16px; height: 16px; stroke: #7c3aed;"></i>
                            {{$lang["home_credit_card"]}}
                        </span>
                        <span class="payment-method-value">R$ {{number_format($n_transactions_creditcard, 2, ",", ".")}}</span>
                    </div>
                    <div class="payment-method-item">
                        <span class="payment-method-label">
                            <i data-lucide="file-text" style="width: 16px; height: 16px; stroke: #7c3aed;"></i>
                            {{$lang["home_boleto"]}}
                        </span>
                        <span class="payment-method-value">R$ {{number_format($n_transactions_boleto, 2, ",", ".")}}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="chart-container">
                    <h4 class="section-title">
                        <i data-lucide="shield"></i>
                        {{$lang["home_payment_brands"]}}
                    </h4>
                    <div class="payment-method-item">
                        <span class="payment-method-label">{{$lang["home_mastercard"]}}</span>
                        <span class="payment-method-value">R$ {{number_format($n_transactions_mastercard, 2, ",", ".")}}</span>
                    </div>
                    <div class="payment-method-item">
                        <span class="payment-method-label">{{$lang["home_visa"]}}</span>
                        <span class="payment-method-value">R$ {{number_format($n_transactions_visa, 2, ",", ".")}}</span>
                    </div>
                    <div class="payment-method-item">
                        <span class="payment-method-label">{{$lang["home_elo"]}}</span>
                        <span class="payment-method-value">R$ {{number_format($n_transactions_elo, 2, ",", ".")}}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="chart-container">
                    <h4 class="section-title">
                        <i data-lucide="alert-circle"></i>
                        {{$lang["home_reason_for_refusal"]}}
                    </h4>
                    <div class="payment-method-item">
                        <span class="payment-method-label">{{$lang["home_no_acquirer_configured"]}}</span>
                        <span class="payment-method-value">0</span>
                    </div>
                    <div class="payment-method-item">
                        <span class="payment-method-label">{{$lang["home_issuer"]}}</span>
                        <span class="payment-method-value">0</span>
                    </div>
                    <div class="payment-method-item">
                        <span class="payment-method-label">{{$lang["home_denied_by_anti_fraud"]}}</span>
                        <span class="payment-method-value">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Future Releases -->
        @if(count($pendingBalanceList) > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="chart-container">
                    <h4 class="section-title">
                        <i data-lucide="calendar"></i>
                        Lançamentos Futuros
                    </h4>
                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th>Valor a Receber</th>
                                    <th>Data Liberação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingBalanceList as $pendingBalanceReg)
                                <tr>
                                    <td>{{date("d/m/Y H:i", strtotime($pendingBalanceReg->created_at))}}</td>
                                    <td>{{$pendingBalanceReg->description}}</td>
                                    <td>{{$currency->symbol}} {{number_format($pendingBalanceReg->amount, 2, ',', '.')}}</td>
                                    <td>{{date("d/m/Y", strtotime($pendingBalanceReg->liquidation_date))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Info Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-card">
                    <i data-lucide="lock" style="width: 32px; height: 32px; stroke: #7c3aed; margin-bottom: 1rem;"></i>
                    <div class="info-value">{{$currency->name}} {{number_format($pendingBalance, 2, '.', '.')}}</div>
                    <div class="info-label">Saldo Bloqueado</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-card">
                    <i data-lucide="download" style="width: 32px; height: 32px; stroke: #7c3aed; margin-bottom: 1rem;"></i>
                    <div class="info-value">{{$currency->name}} {{number_format($t_payout, 2, '.', '')}}</div>
                    <div class="info-label">{{$lang["total_payout"]}}</div>
                    @if($user->business_level==1)
                        <small class="text-muted">{{number_format($t_payout/$set->withdraw_limit*100, 2, '.', '')}}% {{$lang["of_limit"]}}</small>
                    @elseif($user->business_level==2)
                        <small class="text-muted">{{number_format($t_payout/$set->starter_limit*100, 2, '.', '')}}% {{$lang["of_limit"]}}</small>
                    @elseif($user->business_level==3)
                        <small class="text-muted">{{$lang["no_limit"]}}</small>
                    @endif
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-card">
                    <i data-lucide="calendar-check" style="width: 32px; height: 32px; stroke: #7c3aed; margin-bottom: 1rem;"></i>
                    <div class="info-value">{{$currency->name}} {{number_format($n_payout, 2, '.', '')}}</div>
                    <div class="info-label">{{$lang["next_payout"]}}</div>
                    <small class="text-muted">{{$lang["due"]}} {{date("d/m/Y", strtotime($set->next_settlement))}}</small>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="info-card">
                    @if($user->kyc_status==0)
                        <a href="{{route('user.compliance')}}" class="btn btn-sm btn-primary">
                            <i data-lucide="arrow-up" style="width: 16px; height: 16px;"></i>
                            {{$lang["upgrade_account"]}}
                        </a>
                    @else
                        <i data-lucide="check-circle" style="width: 32px; height: 32px; stroke: #22c55e; margin-bottom: 1rem;"></i>
                        <div class="info-label">Conta Verificada</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- API Section -->
        <div class="row">
            <div class="col-12">
                <div class="api-card">
                    <h4 class="text-white mb-4">
                        <i data-lucide="code" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle;"></i>
                        {{$lang["api_documentation"]}}
                    </h4>
                    <p class="text-white opacity-75 mb-4">{{$lang["our_documentation_need_to_integrate"]}} {{$set->site_name}} {{$lang["in_your_website"]}}</p>
                    
                    <a href="https://documenter.getpostman.com/view/2065421/UzXLyHss" target="_blank" class="btn btn-light mb-4">
                        <i data-lucide="book-open" style="width: 16px; height: 16px;"></i>
                        {{$lang["go_to_docs"]}}
                    </a>

                    <h5 class="text-white mb-3">{{$lang["your_keys"]}}</h5>
                    
                    <div class="api-input-wrapper">
                        <span class="text-white opacity-75 mr-3" style="font-size: 0.75rem;">PUBLIC</span>
                        <input type="text" class="api-input" value="{{$user->public_key}}" readonly>
                        <button class="copy-btn btn-icon-clipboard" data-clipboard-text="{{$user->public_key}}">
                            <i data-lucide="copy" style="width: 16px; height: 16px; stroke: white;"></i>
                        </button>
                    </div>

                    <div class="api-input-wrapper">
                        <span class="text-white opacity-75 mr-3" style="font-size: 0.75rem;">SECRET</span>
                        <input type="text" class="api-input" value="{{$user->secret_key}}" readonly>
                        <button class="copy-btn btn-icon-clipboard" data-clipboard-text="{{$user->secret_key}}">
                            <i data-lucide="copy" style="width: 16px; height: 16px; stroke: white;"></i>
                        </button>
                    </div>

                    <div class="api-input-wrapper">
                        <span class="text-white opacity-75 mr-3" style="font-size: 0.75rem;">BASIC</span>
                        <input type="text" class="api-input" value="{{base64_encode($user->public_key. ':' .$user->secret_key)}}" readonly>
                        <button class="copy-btn btn-icon-clipboard" data-clipboard-text="{{base64_encode($user->public_key. ':' .$user->secret_key)}}">
                            <i data-lucide="copy" style="width: 16px; height: 16px; stroke: white;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Producer Tab Content -->
        <div id="producer-tab" class="tab-content" style="display: none;">
            <!-- Producer Metrics Row 1 -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Faturamento Total</span>
                            <i data-lucide="trending-up" class="producer-icon"></i>
                        </div>
                        <div class="producer-value">R$ 0,00</div>
                        <div class="producer-change positive">
                            <i data-lucide="arrow-up" style="width: 14px; height: 14px;"></i>
                            <span>0% este mês</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Vendas Realizadas</span>
                            <i data-lucide="shopping-cart" class="producer-icon"></i>
                        </div>
                        <div class="producer-value">0</div>
                        <div class="producer-change">
                            <i data-lucide="minus" style="width: 14px; height: 14px;"></i>
                            <span>0 novas hoje</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Ticket Médio</span>
                            <i data-lucide="dollar-sign" class="producer-icon"></i>
                        </div>
                        <div class="producer-value">R$ 0,00</div>
                        <div class="producer-change">
                            <i data-lucide="minus" style="width: 14px; height: 14px;"></i>
                            <span>Sem variação</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Taxa de Conversão</span>
                            <i data-lucide="percent" class="producer-icon"></i>
                        </div>
                        <div class="producer-value">0%</div>
                        <div class="producer-change">
                            <i data-lucide="minus" style="width: 14px; height: 14px;"></i>
                            <span>Média do mercado: 2%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Producer Metrics Row 2 -->
            <div class="row mb-4">
                <div class="col-lg-6 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Produtos Ativos</span>
                            <i data-lucide="package" class="producer-icon"></i>
                        </div>
                        <div class="producer-stats">
                            <div class="stat-item">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Cursos</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">0</div>
                                <div class="stat-label">E-books</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Mentorias</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Outros</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Performance de Vendas</span>
                            <i data-lucide="bar-chart-2" class="producer-icon"></i>
                        </div>
                        <div class="producer-chart">
                            <canvas id="salesChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Producer Metrics Row 3 -->
            <div class="row mb-4">
                <div class="col-lg-4 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Clientes</span>
                            <i data-lucide="users" class="producer-icon"></i>
                        </div>
                        <div class="producer-list">
                            <div class="list-item">
                                <span class="list-label">Total de Clientes</span>
                                <span class="list-value">0</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Clientes Ativos</span>
                                <span class="list-value">0</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Novos este mês</span>
                                <span class="list-value">0</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Taxa de Retenção</span>
                                <span class="list-value">0%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Afiliados</span>
                            <i data-lucide="share-2" class="producer-icon"></i>
                        </div>
                        <div class="producer-list">
                            <div class="list-item">
                                <span class="list-label">Total de Afiliados</span>
                                <span class="list-value">0</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Afiliados Ativos</span>
                                <span class="list-value">0</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Vendas por Afiliados</span>
                                <span class="list-value">0</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Comissões Pagas</span>
                                <span class="list-value">R$ 0,00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="producer-card">
                        <div class="producer-card-header">
                            <span class="producer-label">Suporte</span>
                            <i data-lucide="headphones" class="producer-icon"></i>
                        </div>
                        <div class="producer-list">
                            <div class="list-item">
                                <span class="list-label">Tickets Abertos</span>
                                <span class="list-value">0</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Tempo Médio Resposta</span>
                                <span class="list-value">-</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Satisfação</span>
                                <span class="list-value">-</span>
                            </div>
                            <div class="list-item">
                                <span class="list-label">Resolvidos Hoje</span>
                                <span class="list-value">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="row">
                <div class="col-12">
                    <div class="producer-cta">
                        <i data-lucide="rocket" style="width: 48px; height: 48px; stroke: #7c3aed;"></i>
                        <h3>Comece a Vender Seus Produtos Digitais</h3>
                        <p>Configure seus produtos, defina preços e comece a receber pagamentos hoje mesmo.</p>
                        <a href="{{route('user.product')}}" class="btn btn-primary">
                            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                            Criar Primeiro Produto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Scripts -->
<script src="{{url('/')}}/asset/js/amcharts/index.js"></script>
<script src="{{url('/')}}/asset/js/amcharts/xy.js"></script>
<script src="{{url('/')}}/asset/js/amcharts/percent.js"></script>
<script src="{{url('/')}}/asset/js/amcharts/Animated.js"></script>

<script>
// Initialize Lucide Icons
document.addEventListener('DOMContentLoaded', function() {
    if (window.lucide) {
        lucide.createIcons();
    }
});

// Pie Chart
am5.ready(function() {
    var root = am5.Root.new("chart-payment-div");
    
    root.setThemes([
        am5themes_Animated.new(root)
    ]);
    
    var chart = root.container.children.push(am5percent.PieChart.new(root, {
        innerRadius: 60,
        layout: root.verticalLayout
    }));
    
    var series = chart.series.push(am5percent.PieSeries.new(root, {
        valueField: "value",
        categoryField: "category"
    }));
    
    series.set("colors", am5.ColorSet.new(root, {
        colors: [
            am5.color(0x22c55e),
            am5.color(0xf59e0b),
            am5.color(0xef4444)
        ]
    }));
    
    series.data.setAll([
        { category: "Paga", value: {{$n_paid}} },
        { category: "Aguardando", value: {{$n_pending}} },
        { category: "Inadimplente", value: {{$n_defaulter}} }
    ]);
    
    series.labels.template.set("visible", false);
    series.ticks.template.set("visible", false);
    
    series.appear(1000, 100);
});

// Line Chart
@if(count($history)>0)
var ctx = document.getElementById('myChart').getContext('2d');
var gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(124, 58, 237, 0.5)');
gradient.addColorStop(1, 'rgba(109, 40, 217, 0.05)');

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php foreach($history as $val){ echo "'".date("d/m",strtotime($val->updated_at))."'".','; }?>],
        datasets: [{
            label: 'Receita',
            data: [<?php foreach($history as $val){ echo $val->amount.','; }?>],
            backgroundColor: gradient,
            borderColor: '#7c3aed',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#7c3aed',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
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
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    color: '#718096'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#718096'
                }
            }
        }
    }
});
@endif

// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            button.classList.add('active');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
            });
            
            // Show target tab content
            const targetContent = document.getElementById(targetTab + '-tab');
            if (targetContent) {
                targetContent.style.display = 'block';
                targetContent.style.animation = 'fadeIn 0.3s ease';
            }
            
            // Re-initialize Lucide icons
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    });
    
    // Initialize Lucide icons
    if (window.lucide) {
        lucide.createIcons();
    }
});

// Producer Sales Chart (placeholder)
var salesCtx = document.getElementById('salesChart');
if (salesCtx) {
    var salesChart = new Chart(salesCtx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Vendas',
                data: [0, 0, 0, 0, 0, 0],
                backgroundColor: 'rgba(124, 58, 237, 0.5)',
                borderColor: '#7c3aed',
                borderWidth: 1
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
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#718096'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#718096'
                    }
                }
            }
        }
    });
}
</script>
@stop
@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">Reembolsos</h1>
                        <p class="text-light">Gerencie solicitações de reembolso</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#requestRefundModal">
                            <i class="fas fa-undo"></i> Solicitar Reembolso
                        </button>
                    </div>
                </div>

                <!-- Cards de Resumo -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Pendentes</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $stats['pending'] ?? 0 }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                            <i class="fas fa-clock"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Em Análise</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $stats['analyzing'] ?? 0 }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                            <i class="fas fa-search"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Aprovados</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $stats['approved'] ?? 0 }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                            <i class="fas fa-check"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Reembolsado</h5>
                                        <span class="h2 font-weight-bold mb-0">R$ {{ number_format($stats['total_refunded'] ?? 0, 2, ',', '.') }}</span>
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
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Histórico de Reembolsos</h3>
                            </div>
                            <div class="col text-right">
                                <div class="form-inline justify-content-end">
                                    <div class="form-group mr-2">
                                        <select class="form-control form-control-sm" onchange="filterRefunds(this.value)">
                                            <option value="">Todos Status</option>
                                            <option value="pending">Pendente</option>
                                            <option value="analyzing">Em Análise</option>
                                            <option value="approved">Aprovado</option>
                                            <option value="processing">Processando</option>
                                            <option value="completed">Concluído</option>
                                            <option value="rejected">Rejeitado</option>
                                            <option value="cancelled">Cancelado</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Buscar por ID ou transação..." onkeyup="searchRefunds(this.value)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-flush" id="refunds-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Transação</th>
                                        <th>Data Solicitação</th>
                                        <th>Valor Original</th>
                                        <th>Valor Reembolso</th>
                                        <th>Motivo</th>
                                        <th>Status</th>
                                        <th>Processado Em</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($refunds as $refund)
                                    <tr data-status="{{ $refund->status }}" data-id="{{ $refund->id }}" data-transaction="{{ $refund->transaction_id }}">
                                        <td>#{{ $refund->id }}</td>
                                        <td>
                                            <a href="{{ route('user.transactions.show', $refund->transaction_id) }}" class="text-primary">
                                                #{{ $refund->transaction_id }}
                                            </a>
                                        </td>
                                        <td>{{ $refund->created_at->format('d/m/Y H:i') }}</td>
                                        <td>R$ {{ number_format($refund->original_amount, 2, ',', '.') }}</td>
                                        <td>
                                            <strong>R$ {{ number_format($refund->refund_amount, 2, ',', '.') }}</strong>
                                            @if($refund->isPartial())
                                            <span class="badge badge-info">Parcial</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" title="{{ $refund->reason }}">
                                                {{ Str::limit($refund->reason, 30) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $refund->getStatusColor() }}">
                                                {{ $refund->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $refund->processed_at ? $refund->processed_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" 
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{ route('user.refunds.show', $refund->id) }}">
                                                        <i class="fas fa-eye"></i> Ver Detalhes
                                                    </a>
                                                    @if($refund->canBeCancelled())
                                                    <a class="dropdown-item" href="#" onclick="cancelRefund({{ $refund->id }})">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </a>
                                                    @endif
                                                    @if($refund->hasDocuments())
                                                    <a class="dropdown-item" href="{{ route('user.refunds.documents', $refund->id) }}">
                                                        <i class="fas fa-file"></i> Documentos
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($refunds->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-undo fa-4x text-muted mb-3"></i>
                            <h4>Nenhum reembolso encontrado</h4>
                            <p class="text-muted">Você ainda não possui solicitações de reembolso</p>
                        </div>
                        @endif

                        <div class="mt-4">
                            {{ $refunds->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Política de Reembolso -->
        <div class="row mt-4">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Política de Reembolso</h3>
                    </div>
                    <div class="card-body">
                        <h5>Prazos para Solicitação</h5>
                        <ul>
                            <li>Produtos digitais: até 7 dias após a compra</li>
                            <li>Serviços: até 48 horas após a contratação</li>
                            <li>Assinaturas: proporcional ao período não utilizado</li>
                        </ul>

                        <h5 class="mt-3">Motivos Aceitos</h5>
                        <ul>
                            <li>Produto não entregue ou serviço não prestado</li>
                            <li>Produto com defeito ou diferente do anunciado</li>
                            <li>Cobrança duplicada ou indevida</li>
                            <li>Cancelamento dentro do prazo legal</li>
                        </ul>

                        <h5 class="mt-3">Processo de Reembolso</h5>
                        <ol>
                            <li>Solicitação enviada para análise</li>
                            <li>Análise realizada em até 3 dias úteis</li>
                            <li>Aprovação ou rejeição com justificativa</li>
                            <li>Processamento do reembolso em até 7 dias úteis</li>
                            <li>Crédito na forma de pagamento original</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Estatísticas de Reembolso -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Estatísticas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h5>Taxa de Aprovação</h5>
                                <div class="progress mb-1">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $stats['approval_rate'] ?? 0 }}%" 
                                         aria-valuenow="{{ $stats['approval_rate'] ?? 0 }}" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted">{{ $stats['approval_rate'] ?? 0 }}% aprovados</small>
                            </div>
                            <div class="col-12 mb-3">
                                <h5>Tempo Médio de Resposta</h5>
                                <h3 class="text-info">{{ $stats['avg_response_time'] ?? '0' }} dias</h3>
                            </div>
                            <div class="col-12">
                                <h5>Valor Médio de Reembolso</h5>
                                <h3 class="text-primary">R$ {{ number_format($stats['avg_refund_amount'] ?? 0, 2, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motivos Mais Comuns -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="mb-0">Motivos Mais Comuns</h3>
                    </div>
                    <div class="card-body">
                        @foreach($commonReasons ?? [] as $reason)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $reason['reason'] }}</span>
                            <span class="badge badge-primary badge-pill">{{ $reason['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Solicitar Reembolso -->
<div class="modal fade" id="requestRefundModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Solicitar Reembolso</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('user.refunds.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Transação</label>
                        <select name="transaction_id" class="form-control" required onchange="updateTransactionDetails(this.value)">
                            <option value="">Selecione a transação</option>
                            @foreach($eligibleTransactions ?? [] as $transaction)
                            <option value="{{ $transaction->id }}" 
                                    data-amount="{{ $transaction->amount }}" 
                                    data-date="{{ $transaction->created_at->format('d/m/Y') }}">
                                #{{ $transaction->id }} - {{ $transaction->product_name }} - R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="transaction-details" style="display: none;">
                        <div class="alert alert-info">
                            <strong>Detalhes da Transação:</strong><br>
                            Data da compra: <span id="transaction-date">-</span><br>
                            Valor total: <span id="transaction-amount">-</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tipo de Reembolso</label>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" name="refund_type" value="full" class="custom-control-input" id="full-refund" checked onchange="toggleRefundAmount()">
                            <label class="custom-control-label" for="full-refund">
                                Reembolso Total
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" name="refund_type" value="partial" class="custom-control-input" id="partial-refund" onchange="toggleRefundAmount()">
                            <label class="custom-control-label" for="partial-refund">
                                Reembolso Parcial
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="partial-amount-group" style="display: none;">
                        <label>Valor do Reembolso Parcial (R$)</label>
                        <input type="number" name="partial_amount" class="form-control" step="0.01" min="0.01">
                    </div>

                    <div class="form-group">
                        <label>Motivo do Reembolso</label>
                        <select name="reason_type" class="form-control" required onchange="toggleCustomReason(this.value)">
                            <option value="">Selecione o motivo</option>
                            <option value="not_received">Produto/Serviço não recebido</option>
                            <option value="defective">Produto com defeito</option>
                            <option value="not_as_described">Diferente do descrito</option>
                            <option value="duplicate_charge">Cobrança duplicada</option>
                            <option value="cancelled_service">Serviço cancelado</option>
                            <option value="other">Outro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Descrição Detalhada</label>
                        <textarea name="reason_description" class="form-control" rows="4" required 
                                  placeholder="Descreva detalhadamente o motivo da solicitação de reembolso"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Documentos Comprobatórios (opcional)</label>
                        <input type="file" name="documents[]" class="form-control" multiple accept="image/*,.pdf">
                        <small class="form-text text-muted">
                            Você pode anexar imagens ou PDFs que comprovem o motivo do reembolso
                        </small>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="accept-terms" required>
                        <label class="custom-control-label" for="accept-terms">
                            Declaro que as informações fornecidas são verdadeiras e estou ciente da política de reembolso
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
function filterRefunds(status) {
    const rows = document.querySelectorAll('#refunds-table tbody tr');
    rows.forEach(row => {
        if (status === '' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function searchRefunds(term) {
    const searchTerm = term.toLowerCase();
    const rows = document.querySelectorAll('#refunds-table tbody tr');
    rows.forEach(row => {
        const id = row.dataset.id;
        const transaction = row.dataset.transaction;
        if (id.includes(searchTerm) || transaction.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function updateTransactionDetails(transactionId) {
    const select = document.querySelector('select[name="transaction_id"]');
    const option = select.options[select.selectedIndex];
    
    if (transactionId) {
        document.getElementById('transaction-details').style.display = 'block';
        document.getElementById('transaction-date').textContent = option.dataset.date;
        document.getElementById('transaction-amount').textContent = 'R$ ' + parseFloat(option.dataset.amount).toFixed(2).replace('.', ',');
        
        // Atualizar limite do campo de reembolso parcial
        const partialAmountInput = document.querySelector('input[name="partial_amount"]');
        partialAmountInput.max = option.dataset.amount;
    } else {
        document.getElementById('transaction-details').style.display = 'none';
    }
}

function toggleRefundAmount() {
    const isPartial = document.getElementById('partial-refund').checked;
    document.getElementById('partial-amount-group').style.display = isPartial ? 'block' : 'none';
    
    if (isPartial) {
        document.querySelector('input[name="partial_amount"]').required = true;
    } else {
        document.querySelector('input[name="partial_amount"]').required = false;
    }
}

function toggleCustomReason(value) {
    // Pode ser expandido para mostrar campos adicionais baseados no motivo
    console.log('Motivo selecionado:', value);
}

function cancelRefund(id) {
    if (confirm('Tem certeza que deseja cancelar esta solicitação de reembolso?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/refunds') }}/${id}/cancel`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

// Inicializar tooltips
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush

@endsection
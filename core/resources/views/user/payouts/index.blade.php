@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">Saques e Transferências</h1>
                        <p class="text-light">Gerencie seus saques e transferências</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#requestPayoutModal">
                            <i class="fas fa-money-bill-wave"></i> Solicitar Saque
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Saldo Disponível</h5>
                                        <span class="h2 font-weight-bold mb-0">R$ {{ number_format($availableBalance, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                            <i class="fas fa-wallet"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Pendente</h5>
                                        <span class="h2 font-weight-bold mb-0">R$ {{ number_format($pendingAmount, 2, ',', '.') }}</span>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Processando</h5>
                                        <span class="h2 font-weight-bold mb-0">R$ {{ number_format($processingAmount, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                            <i class="fas fa-sync-alt"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Sacado</h5>
                                        <span class="h2 font-weight-bold mb-0">R$ {{ number_format($totalPaidOut, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-purple text-white rounded-circle shadow">
                                            <i class="fas fa-chart-line"></i>
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
                                <h3 class="mb-0">Histórico de Saques</h3>
                            </div>
                            <div class="col text-right">
                                <div class="form-inline justify-content-end">
                                    <div class="form-group mr-2">
                                        <select class="form-control form-control-sm" onchange="filterPayouts(this.value)">
                                            <option value="">Todos Status</option>
                                            <option value="pending">Pendente</option>
                                            <option value="processing">Processando</option>
                                            <option value="completed">Concluído</option>
                                            <option value="failed">Falhado</option>
                                            <option value="cancelled">Cancelado</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" onchange="filterByPeriod(this.value)">
                                            <option value="">Todos Períodos</option>
                                            <option value="today">Hoje</option>
                                            <option value="week">Esta Semana</option>
                                            <option value="month">Este Mês</option>
                                            <option value="year">Este Ano</option>
                                        </select>
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

                        <div class="table-responsive">
                            <table class="table table-flush" id="payouts-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Data Solicitação</th>
                                        <th>Valor</th>
                                        <th>Taxa</th>
                                        <th>Líquido</th>
                                        <th>Método</th>
                                        <th>Status</th>
                                        <th>Processado Em</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payouts as $payout)
                                    <tr data-status="{{ $payout->status }}">
                                        <td>#{{ $payout->id }}</td>
                                        <td>{{ $payout->created_at->format('d/m/Y H:i') }}</td>
                                        <td>R$ {{ number_format($payout->amount, 2, ',', '.') }}</td>
                                        <td>R$ {{ number_format($payout->fee, 2, ',', '.') }}</td>
                                        <td><strong>R$ {{ number_format($payout->net_amount, 2, ',', '.') }}</strong></td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $payout->getPaymentMethodLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $payout->getStatusColor() }}">
                                                {{ $payout->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $payout->processed_at ? $payout->processed_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" 
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{ route('user.payouts.show', $payout->id) }}">
                                                        <i class="fas fa-eye"></i> Ver Detalhes
                                                    </a>
                                                    @if($payout->status == 'pending')
                                                    <a class="dropdown-item" href="#" onclick="cancelPayout({{ $payout->id }})">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </a>
                                                    @endif
                                                    @if($payout->receipt_url)
                                                    <a class="dropdown-item" href="{{ $payout->receipt_url }}" target="_blank">
                                                        <i class="fas fa-file-pdf"></i> Comprovante
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

                        <div class="mt-4">
                            {{ $payouts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contas Bancárias -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Contas Bancárias Cadastradas</h3>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addBankAccountModal">
                                    <i class="fas fa-plus"></i> Adicionar Conta
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($bankAccounts as $account)
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="card border {{ $account->is_default ? 'border-primary' : '' }}">
                                    <div class="card-body">
                                        @if($account->is_default)
                                        <span class="badge badge-primary badge-pill float-right">Padrão</span>
                                        @endif
                                        <h4 class="mb-2">{{ $account->bank_name }}</h4>
                                        <p class="text-sm text-muted mb-2">
                                            <strong>Agência:</strong> {{ $account->agency }}<br>
                                            <strong>Conta:</strong> {{ $account->account_number }}-{{ $account->account_digit }}<br>
                                            <strong>Tipo:</strong> {{ $account->account_type_label }}<br>
                                            <strong>CPF/CNPJ:</strong> {{ $account->document_formatted }}
                                        </p>
                                        <div class="btn-group btn-group-sm w-100">
                                            @if(!$account->is_default)
                                            <button class="btn btn-info" onclick="setDefaultAccount({{ $account->id }})">
                                                <i class="fas fa-star"></i> Tornar Padrão
                                            </button>
                                            @endif
                                            <button class="btn btn-danger" onclick="deleteAccount({{ $account->id }})">
                                                <i class="fas fa-trash"></i> Remover
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-4">
                                    <i class="fas fa-university fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nenhuma conta bancária cadastrada</p>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addBankAccountModal">
                                        <i class="fas fa-plus"></i> Adicionar Primeira Conta
                                    </button>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Solicitar Saque -->
<div class="modal fade" id="requestPayoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Solicitar Saque</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('user.payouts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Saldo disponível: <strong>R$ {{ number_format($availableBalance, 2, ',', '.') }}</strong>
                    </div>

                    <div class="form-group">
                        <label>Valor do Saque (R$)</label>
                        <input type="number" name="amount" class="form-control" 
                               step="0.01" min="{{ $minimumPayout }}" max="{{ $availableBalance }}" required>
                        <small class="form-text text-muted">
                            Valor mínimo: R$ {{ number_format($minimumPayout, 2, ',', '.') }}
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Conta Bancária</label>
                        <select name="bank_account_id" class="form-control" required>
                            <option value="">Selecione uma conta</option>
                            @foreach($bankAccounts as $account)
                            <option value="{{ $account->id }}" {{ $account->is_default ? 'selected' : '' }}>
                                {{ $account->bank_name }} - Ag: {{ $account->agency }} Conta: {{ $account->account_number }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Método de Transferência</label>
                        <select name="payment_method" class="form-control" required onchange="updateFee(this.value)">
                            <option value="pix">PIX (Taxa: R$ {{ number_format($fees['pix'], 2, ',', '.') }})</option>
                            <option value="ted">TED (Taxa: R$ {{ number_format($fees['ted'], 2, ',', '.') }})</option>
                            <option value="doc">DOC (Taxa: R$ {{ number_format($fees['doc'], 2, ',', '.') }})</option>
                        </select>
                    </div>

                    <div class="alert alert-warning">
                        <strong>Resumo:</strong><br>
                        Valor solicitado: <span id="requested-amount">R$ 0,00</span><br>
                        Taxa: <span id="fee-amount">R$ 0,00</span><br>
                        <hr>
                        <strong>Valor líquido a receber: <span id="net-amount">R$ 0,00</span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Solicitar Saque</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Adicionar Conta Bancária -->
<div class="modal fade" id="addBankAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Conta Bancária</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('user.bank-accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banco</label>
                                <select name="bank_code" class="form-control" required>
                                    <option value="">Selecione o banco</option>
                                    <option value="001">001 - Banco do Brasil</option>
                                    <option value="033">033 - Santander</option>
                                    <option value="104">104 - Caixa Econômica</option>
                                    <option value="237">237 - Bradesco</option>
                                    <option value="341">341 - Itaú</option>
                                    <option value="260">260 - Nubank</option>
                                    <option value="077">077 - Banco Inter</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Conta</label>
                                <select name="account_type" class="form-control" required>
                                    <option value="checking">Conta Corrente</option>
                                    <option value="savings">Conta Poupança</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Agência</label>
                                <input type="text" name="agency" class="form-control" maxlength="4" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número da Conta</label>
                                <input type="text" name="account_number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dígito</label>
                                <input type="text" name="account_digit" class="form-control" maxlength="2" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome do Titular</label>
                                <input type="text" name="holder_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPF/CNPJ do Titular</label>
                                <input type="text" name="holder_document" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="is_default" class="custom-control-input" id="is_default">
                        <label class="custom-control-label" for="is_default">
                            Definir como conta padrão para saques
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar Conta</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
const fees = @json($fees);
const minimumPayout = {{ $minimumPayout }};

function updateFee(method) {
    const amountInput = document.querySelector('input[name="amount"]');
    const amount = parseFloat(amountInput.value) || 0;
    const fee = fees[method] || 0;
    const netAmount = amount - fee;

    document.getElementById('requested-amount').textContent = formatCurrency(amount);
    document.getElementById('fee-amount').textContent = formatCurrency(fee);
    document.getElementById('net-amount').textContent = formatCurrency(netAmount);
}

function formatCurrency(value) {
    return 'R$ ' + value.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function filterPayouts(status) {
    const rows = document.querySelectorAll('#payouts-table tbody tr');
    rows.forEach(row => {
        if (status === '' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterByPeriod(period) {
    // Implementar filtro por período via AJAX
    console.log('Filtrar por período:', period);
}

function cancelPayout(id) {
    if (confirm('Tem certeza que deseja cancelar este saque?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/payouts') }}/${id}/cancel`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

function setDefaultAccount(id) {
    if (confirm('Definir esta conta como padrão?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/bank-accounts') }}/${id}/set-default`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteAccount(id) {
    if (confirm('Tem certeza que deseja remover esta conta?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/bank-accounts') }}/${id}`;
        form.innerHTML = '@csrf @method("DELETE")';
        document.body.appendChild(form);
        form.submit();
    }
}

// Atualizar valores ao digitar
document.querySelector('input[name="amount"]').addEventListener('input', function() {
    const method = document.querySelector('select[name="payment_method"]').value;
    updateFee(method);
});
</script>
@endpush

@endsection
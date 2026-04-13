@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">Configuração de Pagamentos</h1>
                        <p class="text-light">Gerencie taxas, métodos de pagamento e splits</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addMethodModal">
                            <i class="fas fa-plus"></i> Adicionar Método
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <!-- Configuração de Taxas -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Estrutura de Taxas</h3>
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
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Método de Pagamento</th>
                                        <th>Taxa Fixa</th>
                                        <th>Taxa Percentual</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feeStructures as $fee)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-{{ $fee->getIcon() }} mr-2 text-primary"></i>
                                                <div>
                                                    <h4 class="mb-0">{{ $fee->getDisplayName() }}</h4>
                                                    <small class="text-muted">{{ $fee->payment_method }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>R$ {{ number_format($fee->fixed_fee, 2, ',', '.') }}</td>
                                        <td>{{ number_format($fee->percentage_fee, 2, ',', '.') }}%</td>
                                        <td>
                                            <span class="badge badge-{{ $fee->is_active ? 'success' : 'danger' }}">
                                                {{ $fee->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editFee({{ $fee->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-{{ $fee->is_active ? 'warning' : 'success' }}" 
                                                    onclick="toggleFee({{ $fee->id }})">
                                                <i class="fas fa-{{ $fee->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Split de Pagamentos -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="mb-0">Splits de Pagamento</h3>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#addSplitModal">
                            <i class="fas fa-plus"></i> Criar Split
                        </button>

                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Recipientes</th>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentSplits as $split)
                                    <tr>
                                        <td>{{ $split->name }}</td>
                                        <td>
                                            @foreach($split->recipients as $recipient)
                                            <span class="badge badge-info">{{ $recipient['name'] }}: {{ $recipient['percentage'] }}%</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ ucfirst($split->split_type) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $split->is_active ? 'success' : 'danger' }}">
                                                {{ $split->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editSplit({{ $split->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteSplit({{ $split->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Nenhum split configurado</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumo e Estatísticas -->
            <div class="col-xl-4">
                <!-- Resumo de Taxas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Resumo de Taxas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h5>Taxa Média Cobrada</h5>
                                <h2 class="text-primary">{{ number_format($averageFee, 2, ',', '.') }}%</h2>
                            </div>
                            <div class="col-12 mb-3">
                                <h5>Total em Taxas (Mês)</h5>
                                <h3 class="text-success">R$ {{ number_format($totalFeesMonth, 2, ',', '.') }}</h3>
                            </div>
                            <div class="col-12">
                                <h5>Métodos Ativos</h5>
                                <h3 class="text-info">{{ $activeMethodsCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configurações de Parcelamento -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="mb-0">Configuração de Parcelamento</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.payment-configuration.update-installments') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Parcelas Máximas</label>
                                <input type="number" name="max_installments" class="form-control" 
                                       value="{{ $installmentConfig->max_installments ?? 12 }}" min="1" max="24">
                            </div>
                            <div class="form-group">
                                <label>Parcela Mínima (R$)</label>
                                <input type="number" name="min_installment_amount" class="form-control" 
                                       value="{{ $installmentConfig->min_installment_amount ?? 50 }}" min="5" step="0.01">
                            </div>
                            <div class="form-group">
                                <label>Taxa de Juros ao Mês (%)</label>
                                <input type="number" name="interest_rate" class="form-control" 
                                       value="{{ $installmentConfig->interest_rate ?? 2.99 }}" min="0" max="10" step="0.01">
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" name="show_installment_savings" class="custom-control-input" id="show_savings"
                                       {{ ($installmentConfig->show_installment_savings ?? false) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="show_savings">
                                    Mostrar economia no pagamento à vista
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Salvar Configuração
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Gateways Configurados -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="mb-0">Gateways de Pagamento</h3>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($gateways as $gateway)
                            <div class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="mb-0">{{ $gateway->name }}</h5>
                                        <small class="text-muted">{{ $gateway->provider }}</small>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" 
                                                   id="gateway-{{ $gateway->id }}" 
                                                   {{ $gateway->is_active ? 'checked' : '' }}
                                                   onchange="toggleGateway({{ $gateway->id }})">
                                            <label class="custom-control-label" for="gateway-{{ $gateway->id }}"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar Método -->
<div class="modal fade" id="addMethodModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Método de Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('user.payment-configuration.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Método de Pagamento</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">Selecione...</option>
                            <option value="pix">PIX</option>
                            <option value="credit_card">Cartão de Crédito</option>
                            <option value="debit_card">Cartão de Débito</option>
                            <option value="boleto">Boleto</option>
                            <option value="bank_transfer">Transferência Bancária</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Taxa Fixa (R$)</label>
                        <input type="number" name="fixed_fee" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Taxa Percentual (%)</label>
                        <input type="number" name="percentage_fee" class="form-control" step="0.01" min="0" max="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Adicionar Split -->
<div class="modal fade" id="addSplitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Split de Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('user.payment-configuration.create-split') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome do Split</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Split</label>
                        <select name="split_type" class="form-control" required>
                            <option value="percentage">Percentual</option>
                            <option value="fixed">Valor Fixo</option>
                        </select>
                    </div>
                    <div id="recipients-container">
                        <label>Recipientes</label>
                        <div class="recipient-row mb-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="recipients[0][name]" class="form-control" placeholder="Nome do recipiente" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="recipients[0][value]" class="form-control" placeholder="Valor/Percentual" step="0.01" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRecipient(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-info" onclick="addRecipient()">
                        <i class="fas fa-plus"></i> Adicionar Recipiente
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Split</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
let recipientIndex = 1;

function addRecipient() {
    const container = document.getElementById('recipients-container');
    const newRow = document.createElement('div');
    newRow.className = 'recipient-row mb-2';
    newRow.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="recipients[${recipientIndex}][name]" class="form-control" placeholder="Nome do recipiente" required>
            </div>
            <div class="col-md-4">
                <input type="number" name="recipients[${recipientIndex}][value]" class="form-control" placeholder="Valor/Percentual" step="0.01" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRecipient(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    recipientIndex++;
}

function removeRecipient(button) {
    button.closest('.recipient-row').remove();
}

function editFee(id) {
    // Implementar edição via AJAX ou modal
    alert('Função de edição será implementada');
}

function toggleFee(id) {
    if (confirm('Deseja alterar o status desta taxa?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/payment-configuration/fee') }}/${id}/toggle`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

function editSplit(id) {
    // Implementar edição via AJAX ou modal
    alert('Função de edição será implementada');
}

function deleteSplit(id) {
    if (confirm('Tem certeza que deseja excluir este split?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/payment-configuration/split') }}/${id}`;
        form.innerHTML = '@csrf @method("DELETE")';
        document.body.appendChild(form);
        form.submit();
    }
}

function toggleGateway(id) {
    // Implementar toggle via AJAX
    fetch(`{{ url('user/payment-configuration/gateway') }}/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (!response.ok) {
            alert('Erro ao alterar status do gateway');
        }
    });
}
</script>
@endpush

@endsection
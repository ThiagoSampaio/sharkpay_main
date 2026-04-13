@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">Checkout Builder</h1>
                        <p class="text-light">Crie checkouts otimizados para maximizar suas conversões</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="{{ route('user.checkout-builder.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Criar Novo Checkout
                        </a>
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
                                <h3 class="mb-0">Meus Checkouts</h3>
                            </div>
                            <div class="col text-right">
                                <div class="form-inline justify-content-end">
                                    <div class="form-group mr-2">
                                        <select class="form-control form-control-sm" onchange="filterCheckouts(this.value)">
                                            <option value="">Todos Status</option>
                                            <option value="active">Ativos</option>
                                            <option value="inactive">Inativos</option>
                                            <option value="draft">Rascunhos</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Buscar..." onkeyup="searchCheckouts(this.value)">
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

                        @if($checkouts->count() > 0)
                        <div class="row" id="checkouts-grid">
                            @foreach($checkouts as $checkout)
                            <div class="col-xl-4 col-md-6 mb-4 checkout-card" data-status="{{ $checkout->status }}" data-name="{{ strtolower($checkout->name) }}">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0">{{ $checkout->name }}</h4>
                                        <span class="badge badge-{{ $checkout->status == 'active' ? 'success' : ($checkout->status == 'inactive' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($checkout->status) }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-sm text-muted">{{ $checkout->description ?? 'Sem descrição' }}</p>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <p class="text-xs text-muted mb-1">Taxa de Conversão</p>
                                                <h5 class="mb-0">{{ $checkout->conversion_rate_formatted ?? '0%' }}</h5>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-xs text-muted mb-1">Total de Pedidos</p>
                                                <h5 class="mb-0">{{ $checkout->total_orders }}</h5>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <p class="text-xs text-muted mb-1">Receita Total</p>
                                                <h5 class="mb-0">R$ {{ number_format($checkout->total_revenue, 2, ',', '.') }}</h5>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            @if($checkout->hasUpsells())
                                            <span class="badge badge-info badge-sm">Upsell Ativo</span>
                                            @endif
                                            @if($checkout->hasDownsells())
                                            <span class="badge badge-warning badge-sm">Downsell Ativo</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light">
                                        <div class="btn-group btn-group-sm w-100">
                                            <a href="{{ route('user.checkout-builder.show', $checkout->id) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            <a href="{{ route('user.checkout-builder.edit', $checkout->id) }}" class="btn btn-info">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <button onclick="duplicateCheckout({{ $checkout->id }})" class="btn btn-success">
                                                <i class="fas fa-copy"></i> Duplicar
                                            </button>
                                        </div>
                                        <div class="btn-group btn-group-sm w-100 mt-2">
                                            @if($checkout->status == 'active')
                                            <button onclick="toggleCheckout({{ $checkout->id }}, 'deactivate')" class="btn btn-warning">
                                                <i class="fas fa-pause"></i> Desativar
                                            </button>
                                            @else
                                            <button onclick="toggleCheckout({{ $checkout->id }}, 'activate')" class="btn btn-success">
                                                <i class="fas fa-play"></i> Ativar
                                            </button>
                                            @endif
                                            <a href="{{ $checkout->checkout_url }}" target="_blank" class="btn btn-secondary">
                                                <i class="fas fa-external-link-alt"></i> Preview
                                            </a>
                                            @if($checkout->total_orders == 0)
                                            <button onclick="deleteCheckout({{ $checkout->id }})" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $checkouts->links() }}
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                            <h4>Nenhum checkout criado ainda</h4>
                            <p class="text-muted">Comece criando seu primeiro checkout otimizado para conversões</p>
                            <a href="{{ route('user.checkout-builder.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus"></i> Criar Primeiro Checkout
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas Gerais -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Estatísticas Gerais dos Checkouts</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h2 class="text-primary">{{ $checkouts->where('status', 'active')->count() }}</h2>
                                    <p class="text-muted">Checkouts Ativos</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h2 class="text-success">{{ $checkouts->sum('total_orders') }}</h2>
                                    <p class="text-muted">Total de Pedidos</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h2 class="text-info">R$ {{ number_format($checkouts->sum('total_revenue'), 2, ',', '.') }}</h2>
                                    <p class="text-muted">Receita Total</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h2 class="text-warning">
                                        {{ $checkouts->count() > 0 ? number_format($checkouts->avg('conversion_rate'), 2) : 0 }}%
                                    </h2>
                                    <p class="text-muted">Taxa Média de Conversão</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
function filterCheckouts(status) {
    const cards = document.querySelectorAll('.checkout-card');
    cards.forEach(card => {
        if (status === '' || card.dataset.status === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function searchCheckouts(term) {
    const searchTerm = term.toLowerCase();
    const cards = document.querySelectorAll('.checkout-card');
    cards.forEach(card => {
        const name = card.dataset.name;
        if (name.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function toggleCheckout(id, action) {
    if (confirm(`Deseja realmente ${action === 'activate' ? 'ativar' : 'desativar'} este checkout?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/checkout-builder') }}/${id}/${action}`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

function duplicateCheckout(id) {
    if (confirm('Deseja duplicar este checkout?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/checkout-builder') }}/${id}/duplicate`;
        form.innerHTML = '@csrf';
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteCheckout(id) {
    if (confirm('Tem certeza que deseja excluir este checkout? Esta ação não pode ser desfeita.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('user/checkout-builder') }}/${id}`;
        form.innerHTML = '@csrf @method("DELETE")';
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

@endsection
@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-dark d-inline-block mb-0">Métodos de Pagamento</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('seller.settings') }}">Configurações</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Métodos de Pagamento</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addMethodModal">
                            <i class="fas fa-plus"></i> Adicionar Método
                        </button>
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
                        <h3 class="mb-0">Seus Métodos de Saque</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($methods->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-items-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Método</th>
                                            <th>Detalhes</th>
                                            <th>Padrão</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($methods as $method)
                                            <tr>
                                                <td>
                                                    @if($method->method == 'pix')
                                                        <i class="fas fa-qrcode text-primary"></i> PIX
                                                    @else
                                                        <i class="fas fa-university text-info"></i> Transferência Bancária
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $details = json_decode($method->details, true);
                                                    @endphp
                                                    @if($method->method == 'pix')
                                                        {{ $details['pix_key'] ?? 'N/A' }}
                                                    @else
                                                        Banco: {{ $details['bank_name'] ?? 'N/A' }}<br>
                                                        Agência: {{ $details['agency'] ?? 'N/A' }} | Conta: {{ $details['account'] ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($method->is_default)
                                                        <span class="badge badge-success">Sim</span>
                                                    @else
                                                        <span class="badge badge-secondary">Não</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhum método de pagamento cadastrado.</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMethodModal">
                                    Adicionar Primeiro Método
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar Método -->
<div class="modal fade" id="addMethodModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('seller.settings.payment-methods.add') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Método de Pagamento</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipo de Método</label>
                        <select name="method" class="form-control" id="methodType" required>
                            <option value="">Selecione...</option>
                            <option value="pix">PIX</option>
                            <option value="bank_transfer">Transferência Bancária</option>
                        </select>
                    </div>

                    <div id="pixFields" style="display:none;">
                        <div class="form-group">
                            <label>Chave PIX</label>
                            <input type="text" name="details[pix_key]" class="form-control" placeholder="Digite sua chave PIX">
                        </div>
                    </div>

                    <div id="bankFields" style="display:none;">
                        <div class="form-group">
                            <label>Nome do Banco</label>
                            <input type="text" name="details[bank_name]" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agência</label>
                                    <input type="text" name="details[agency]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Conta</label>
                                    <input type="text" name="details[account]" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="isDefault" name="is_default">
                        <label class="custom-control-label" for="isDefault">Definir como padrão</label>
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

@push('scripts')
<script>
$(document).ready(function() {
    $('#methodType').change(function() {
        const method = $(this).val();
        $('#pixFields, #bankFields').hide();

        if (method === 'pix') {
            $('#pixFields').show();
        } else if (method === 'bank_transfer') {
            $('#bankFields').show();
        }
    });
});
</script>
@endpush

@endsection

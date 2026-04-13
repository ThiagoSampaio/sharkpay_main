@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6">
                        <h1 class="display-4 text-white">Configurações Fiscais</h1>
                        <p class="text-light">Gerencie suas informações fiscais e tributárias</p>
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
                        <h3 class="mb-0">Informações Fiscais</h3>
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

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('seller.settings.tax.update') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">CPF/CNPJ *</label>
                                        <input type="text" name="cpf_cnpj" class="form-control"
                                               value="{{ old('cpf_cnpj', $taxSettings['cpf_cnpj']) }}" required>
                                        <small class="form-text text-muted">Informe seu CPF ou CNPJ</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Razão Social / Nome Completo</label>
                                        <input type="text" name="company_name" class="form-control"
                                               value="{{ old('company_name', $taxSettings['company_name']) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Regime Tributário *</label>
                                        <select name="tax_regime" class="form-control" required>
                                            <option value="simples" {{ $taxSettings['tax_regime'] == 'simples' ? 'selected' : '' }}>Simples Nacional</option>
                                            <option value="lucro_presumido" {{ $taxSettings['tax_regime'] == 'lucro_presumido' ? 'selected' : '' }}>Lucro Presumido</option>
                                            <option value="lucro_real" {{ $taxSettings['tax_regime'] == 'lucro_real' ? 'selected' : '' }}>Lucro Real</option>
                                            <option value="mei" {{ $taxSettings['tax_regime'] == 'mei' ? 'selected' : '' }}>MEI</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Inscrição Municipal</label>
                                        <input type="text" name="municipal_registration" class="form-control"
                                               value="{{ old('municipal_registration', $taxSettings['municipal_registration']) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Inscrição Estadual</label>
                                        <input type="text" name="state_registration" class="form-control"
                                               value="{{ old('state_registration', $taxSettings['state_registration']) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="issue_nf" class="custom-control-input" id="issue_nf"
                                               {{ $taxSettings['issue_nf'] ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="issue_nf">
                                            Emitir Nota Fiscal automaticamente
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="text-right">
                                <a href="{{ route('seller.settings') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

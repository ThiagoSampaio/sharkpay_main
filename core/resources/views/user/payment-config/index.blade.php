@extends('userlayout')

@section('content')
<div class="container-fluid mt--6">
  <div class="content-wrapper">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 d-inline-block mb-0">Configuração de Métodos de Pagamento</h6>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <form action="{{route('user.payment-config.reset')}}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Tem certeza que deseja resetar para os valores padrão?')"><i class="fad fa-undo"></i> Resetar Padrões</button>
        </form>
        <a href="{{route('user.payment-config.export')}}" class="btn btn-sm btn-info"><i class="fad fa-download"></i> Exportar</a>
      </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="fad fa-check-circle"></i></span>
        <span class="alert-text">{{ session('success') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="fad fa-exclamation-circle"></i></span>
        <span class="alert-text">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0 font-weight-bolder">Métodos de Pagamento Habilitados</h3>
          </div>
          <div class="card-body">
            <form action="{{route('user.payment-config.payment-methods')}}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="pix_enabled" name="pix_enabled" value="1" {{ $settings['pix_enabled'] ? 'checked' : '' }}>
                    <label class="custom-control-label" for="pix_enabled">
                      <strong>PIX</strong>
                    </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="credit_card_enabled" name="credit_card_enabled" value="1" {{ $settings['credit_card_enabled'] ? 'checked' : '' }}>
                    <label class="custom-control-label" for="credit_card_enabled">
                      <strong>Cartão de Crédito</strong>
                    </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="boleto_enabled" name="boleto_enabled" value="1" {{ $settings['boleto_enabled'] ? 'checked' : '' }}>
                    <label class="custom-control-label" for="boleto_enabled">
                      <strong>Boleto Bancário</strong>
                    </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="bank_transfer_enabled" name="bank_transfer_enabled" value="1" {{ $settings['bank_transfer_enabled'] ? 'checked' : '' }}>
                    <label class="custom-control-label" for="bank_transfer_enabled">
                      <strong>Transferência Bancária</strong>
                    </label>
                  </div>
                </div>
              </div>
              <div class="text-right mt-3">
                <button type="submit" class="btn btn-primary">Salvar Métodos</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0 font-weight-bolder">Configuração de Taxas</h3>
          </div>
          <div class="card-body">
            <form action="{{route('user.payment-config.fees')}}" method="post">
              @csrf

              <!-- PIX -->
              <div class="border-bottom pb-3 mb-3">
                <h4 class="font-weight-bold">PIX</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Percentual (%)</label>
                      <input type="number" step="0.01" name="pix_fee_percentage" class="form-control" value="{{ $settings['pix_fee_percentage'] ?? 0 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Fixa (R$)</label>
                      <input type="number" step="0.01" name="pix_fee_fixed" class="form-control" value="{{ $settings['pix_fee_fixed'] ?? 0 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Mínimo (R$)</label>
                      <input type="number" step="0.01" name="pix_min_amount" class="form-control" value="{{ $settings['pix_min_amount'] ?? 1 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Máximo (R$)</label>
                      <input type="number" step="0.01" name="pix_max_amount" class="form-control" value="{{ $settings['pix_max_amount'] ?? 999999 }}">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Cartão de Crédito -->
              <div class="border-bottom pb-3 mb-3">
                <h4 class="font-weight-bold">Cartão de Crédito</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Percentual (%)</label>
                      <input type="number" step="0.01" name="credit_card_fee_percentage" class="form-control" value="{{ $settings['credit_card_fee_percentage'] ?? 3.5 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Fixa (R$)</label>
                      <input type="number" step="0.01" name="credit_card_fee_fixed" class="form-control" value="{{ $settings['credit_card_fee_fixed'] ?? 0.39 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Mínimo (R$)</label>
                      <input type="number" step="0.01" name="credit_card_min_amount" class="form-control" value="{{ $settings['credit_card_min_amount'] ?? 5 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Máximo (R$)</label>
                      <input type="number" step="0.01" name="credit_card_max_amount" class="form-control" value="{{ $settings['credit_card_max_amount'] ?? 999999 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Máximo de Parcelas</label>
                      <input type="number" name="credit_card_max_installments" class="form-control" value="{{ $settings['credit_card_max_installments'] ?? 12 }}">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Boleto -->
              <div class="border-bottom pb-3 mb-3">
                <h4 class="font-weight-bold">Boleto Bancário</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Percentual (%)</label>
                      <input type="number" step="0.01" name="boleto_fee_percentage" class="form-control" value="{{ $settings['boleto_fee_percentage'] ?? 0 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Fixa (R$)</label>
                      <input type="number" step="0.01" name="boleto_fee_fixed" class="form-control" value="{{ $settings['boleto_fee_fixed'] ?? 3.50 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Mínimo (R$)</label>
                      <input type="number" step="0.01" name="boleto_min_amount" class="form-control" value="{{ $settings['boleto_min_amount'] ?? 5 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Máximo (R$)</label>
                      <input type="number" step="0.01" name="boleto_max_amount" class="form-control" value="{{ $settings['boleto_max_amount'] ?? 999999 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Dias para Vencimento</label>
                      <input type="number" name="boleto_due_days" class="form-control" value="{{ $settings['boleto_due_days'] ?? 3 }}">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Transferência Bancária -->
              <div class="pb-3 mb-3">
                <h4 class="font-weight-bold">Transferência Bancária</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Percentual (%)</label>
                      <input type="number" step="0.01" name="bank_transfer_fee_percentage" class="form-control" value="{{ $settings['bank_transfer_fee_percentage'] ?? 0 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Taxa Fixa (R$)</label>
                      <input type="number" step="0.01" name="bank_transfer_fee_fixed" class="form-control" value="{{ $settings['bank_transfer_fee_fixed'] ?? 0 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Mínimo (R$)</label>
                      <input type="number" step="0.01" name="bank_transfer_min_amount" class="form-control" value="{{ $settings['bank_transfer_min_amount'] ?? 1 }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="form-control-label">Valor Máximo (R$)</label>
                      <input type="number" step="0.01" name="bank_transfer_max_amount" class="form-control" value="{{ $settings['bank_transfer_max_amount'] ?? 999999 }}">
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-right">
                <button type="submit" class="btn btn-primary">Salvar Taxas</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Taxas de Parcelamento -->
    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0 font-weight-bolder">Taxas de Parcelamento (Cartão de Crédito)</h3>
          </div>
          <div class="card-body">
            <form action="{{route('user.payment-config.installment-fees')}}" method="post">
              @csrf
              <div class="row">
                @for($i = 1; $i <= 12; $i++)
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="form-control-label">{{ $i }}x - Taxa (%)</label>
                    <input type="number" step="0.01" name="installment_fees[{{ $i }}]" class="form-control" value="{{ $installmentFees[$i] ?? 0 }}">
                  </div>
                </div>
                @endfor
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">Salvar Taxas de Parcelamento</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

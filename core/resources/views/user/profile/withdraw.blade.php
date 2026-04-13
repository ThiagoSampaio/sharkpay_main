@extends('userlayout')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
                @php
                    $paidCount = count($withdraw->where('status', 1));
                    $pendingCount = count($withdraw->where('status', 0));
                    $declinedCount = count($withdraw->where('status', 2));
                @endphp
                <div class="panel-page-stack">
                    <div class="panel-page-hero">
                        <span class="panel-page-hero__eyebrow"><i data-lucide="wallet" style="width: 14px; height: 14px;"></i> Gestao de saques</span>
                        <h1 class="panel-page-hero__title">Solicite repasses, acompanhe o status dos pagamentos e monitore seu limite disponivel.</h1>
                        <p class="panel-page-hero__copy">Esta area concentra o historico de pedidos de saque, o valor efetivo a receber apos taxas e a disponibilidade do seu limite operacional. Use o modal de solicitacao apenas quando os dados PIX estiverem corretos e o valor desejado estiver dentro da faixa liberada.</p>
                        <div class="panel-page-hero__actions">
                            <a data-toggle="modal" data-target="#modal-formx" href="" class="btn btn-neutral">
                                <i class="fad fa-plus"></i> {{$lang["profile_withdraw_withdraw_request"]}}
                            </a>
                        </div>
                        <div class="panel-page-hero__meta">
                            <div class="panel-page-meta-card">
                                <span>Saques pagos</span>
                                <strong>{{ $paidCount }}</strong>
                            </div>
                            <div class="panel-page-meta-card">
                                <span>Saques pendentes</span>
                                <strong>{{ $pendingCount }}</strong>
                            </div>
                            <div class="panel-page-meta-card">
                                <span>Limite disponivel</span>
                                <strong>{{$currency->name}} {{number_format($withdrawLimits->available_limit, 2, ',', '.')}}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="panel-summary-grid">
                        <div class="panel-summary-card">
                            <span class="panel-summary-card__label">Sacado hoje</span>
                            <strong class="panel-summary-card__value">{{$currency->name}} {{number_format($received, 2, ',', '.')}}</strong>
                            <span class="panel-summary-card__hint">Volume liberado no dia</span>
                        </div>
                        <div class="panel-summary-card">
                            <span class="panel-summary-card__label">Pendente</span>
                            <strong class="panel-summary-card__value">{{$currency->name}} {{number_format($pending, 2, ',', '.')}}</strong>
                            <span class="panel-summary-card__hint">Pedidos em analise ou processamento</span>
                        </div>
                        <div class="panel-summary-card">
                            <span class="panel-summary-card__label">Limite disponivel</span>
                            <strong class="panel-summary-card__value">{{$currency->name}} {{number_format($withdrawLimits->available_limit, 2, ',', '.')}}</strong>
                            <span class="panel-summary-card__hint">Valor que ainda pode ser solicitado</span>
                        </div>
                        <div class="panel-summary-card">
                            <span class="panel-summary-card__label">Limite total</span>
                            <strong class="panel-summary-card__value">{{$currency->name}} {{number_format($withdrawLimits->total_limit, 2, ',', '.')}}</strong>
                            <span class="panel-summary-card__hint">Capacidade operacional configurada</span>
                        </div>
                    </div>

                    <div class="panel-note">
                        <i data-lucide="badge-info" style="width: 18px; height: 18px;"></i>
                        <div>
                            <strong>Antes de solicitar um novo saque.</strong>
                            <p>Confira chave PIX, tipo da chave, valor liquido e limite disponivel. Se houver recusas anteriores, revise a mensagem do ultimo pedido para evitar nova rejeicao por dado bancario incorreto.</p>
                        </div>
                    </div>

      <div class="row">
          <div class="col-md-8">
              <div class="row">  
                  @if(count($withdraw)>0) 
                      @foreach($withdraw as $k=>$val)
                      <div class="col-md-6">
                                                    <div class="card bg-white">
                              <div class="card-body">
                                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                                            <div>
                                                                                    <span class="panel-summary-card__label">Referencia</span>
                                                                                    <h5 class="h4 mb-1 font-weight-bolder">{{$val->reference}}</h5>
                                                                            </div>
                                                                            @if($val->type==2)
                                                                                <span class="badge badge-pill badge-primary"><i class="fad fa-user"></i> {{$lang["profile_withdraw_sub_account"]}}</span>
                                                                            @elseif($val->type==1)
                                                                                <span class="badge badge-pill badge-primary"><i class="fad fa-user"></i> {{$lang["profile_withdraw_main"]}}</span>
                                                                            @endif
                                  </div>
                                                                    <div class="panel-summary-grid" style="grid-template-columns: repeat(3, minmax(0, 1fr)); gap: .65rem;">
                                                                            <div class="panel-summary-card" style="padding: .85rem .9rem; border-radius: 16px; box-shadow: none;">
                                                                                <span class="panel-summary-card__label">Total</span>
                                                                                <strong class="panel-summary-card__value" style="font-size: 1rem;">{{$currency->symbol.number_format(($val->amount + $val->charge), 2, '.', '')}}</strong>
                                                                            </div>
                                                                            <div class="panel-summary-card" style="padding: .85rem .9rem; border-radius: 16px; box-shadow: none;">
                                                                                <span class="panel-summary-card__label">Taxas</span>
                                                                                <strong class="panel-summary-card__value" style="font-size: 1rem;">{{$currency->symbol.number_format($val->charge, 2, '.', '')}}</strong>
                                                                            </div>
                                                                            <div class="panel-summary-card" style="padding: .85rem .9rem; border-radius: 16px; box-shadow: none;">
                                                                                <span class="panel-summary-card__label">Liquido</span>
                                                                                <strong class="panel-summary-card__value" style="font-size: 1rem;">{{$currency->symbol.number_format($val->amount, 2, '.', '')}}</strong>
                                                                            </div>
                                                                    </div>

                                                                    <p class="text-sm mb-3 mt-3">{{$lang["profile_withdraw_date"]}}: {{date("d/m/Y H:i", strtotime($val->created_at))}}</p>

                                                                    <div>
                                        @if($val->status==1)
                                          <span class="badge badge-pill badge-success"><i class="fad fa-check"></i> {{$lang["profile_withdraw_paid_out"]}}</span>
                                        @elseif($val->status==0)
                                          <span class="badge badge-pill badge-danger"><i class="fad fa-spinner"></i>  {{$lang["profile_withdraw_pending"]}}</span>                        
                                        @elseif($val->status==2)
                                          <span class="badge badge-pill badge-info"><i class="fad fa-ban"></i> {{$lang["profile_withdraw_declined"]}}</span> <br>
                                          <p class="text-danger m-2">{{$val->error_msg}}</p>
                                        @endif
                                  </div>
                              </div>
                          </div>
                      </div> 
                      @endforeach
                  @else
                      <div class="col-md-12 mb-5">
                          <div class="text-center mt-8">
                              <div class="mb-3">
                                  <img src="{{url('/')}}/asset/images/empty.svg">
                              </div>
                              <h3 class="text-dark">{{$lang["profile_withdraw_no_payout"]}}</h3>
                              <p class="text-dark text-sm card-text">{{$lang["profile_withdraw_we_couldnt_find_any_payouts"]}}</p>
                          </div>
                      </div>
                  @endif
              </div> 



              <div class="row">
                  <div class="col-md-12">
                      {{ $withdraw->links('pagination::bootstrap-4') }}
                  </div>
              </div>
          </div> 

          <div class="col-md-4">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mb-4 text-primary font-weight-bolder">{{$lang["profile_withdraw_statistics"]}}</h4>
                      <div class="payment-method-item">
                        <span class="payment-method-label">Sacado hoje</span>
                        <span class="payment-method-value">{{$currency->name}} {{number_format($received, 2, ',', '.')}}</span>
                      </div>
                      <div class="payment-method-item">
                        <span class="payment-method-label">Saques pendentes</span>
                        <span class="payment-method-value">{{$currency->name}} {{number_format($pending, 2, ',', '.')}}</span>
                      </div>
                      <div class="payment-method-item">
                        <span class="payment-method-label">Limite disponivel</span>
                        <span class="payment-method-value">{{$currency->name}} {{number_format($withdrawLimits->available_limit, 2, ',', '.')}}</span>
                      </div>
                      <div class="payment-method-item">
                        <span class="payment-method-label">Limite total</span>
                        <span class="payment-method-value">{{$currency->name}} {{number_format($withdrawLimits->total_limit, 2, ',', '.')}}</span>
                      </div>

                      <div class="panel-note mt-4">
                        <i data-lucide="landmark" style="width: 18px; height: 18px;"></i>
                        <div>
                          <strong>Liquidez e disciplina operacional.</strong>
                          <p>Evite concentrar pedidos em valores muito acima do necessario. Isso melhora previsibilidade de caixa e reduz risco de exceder limite ou gerar divergencia de conciliacao.</p>
                        </div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
  </div>

  
    <div class="modal fade" id="modal-formx" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                                <div class="card-header">
                                        <h3 class="mb-0 font-weight-bolder">{{$lang["profile_withdraw_create_paout_request"]}}</h3>
                                        <p class="text-sm mb-0 mt-2">Informe o valor desejado e os dados PIX corretos. O sistema calcula automaticamente o valor liquido que sera recebido apos taxas.</p>
                                </div>

                <div class="modal-body">

                                        <div class="panel-summary-grid mb-4">
                                            <div class="panel-summary-card" style="box-shadow:none;">
                                                <span class="panel-summary-card__label">Limite disponivel</span>
                                                <strong class="panel-summary-card__value">{{$currency->symbol . ' ' . number_format($withdrawLimits->available_limit, 2, ',', '.')}}</strong>
                                            </div>
                                            <div class="panel-summary-card" style="box-shadow:none;">
                                                <span class="panel-summary-card__label">Taxa fixa + percentual</span>
                                                <strong class="panel-summary-card__value">{{number_format($userTax->withdraw_charge, 2, ',', '.')}}% + {{$currency->symbol . ' ' . number_format($userTax->withdraw_chargep, 2, ',', '.')}}</strong>
                                            </div>
                                        </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{$currency->symbol}}
                                    </span>
                                </div>
                                <input type="text"  name="withdraw-amount" id="withdraw-amount" class="form-control money-mask" placeholder="0.00"  required>
                                <input type="hidden" value="{{$userTax->withdraw_charge}}" id="chargetransfer3">
                                <input type="hidden" value="{{$userTax->withdraw_chargep}}" id="chargetransferx">
                            </div>
                          
                            <span class="form-text text-xs">
                                {{$lang["profile_withdraw_wihdraw_charge_is"]}} {{number_format($userTax->withdraw_charge, 2, ",", ".")}}% + {{$currency->symbol . " " . number_format($userTax->withdraw_chargep, 2, ",", ".")}}, 
                                & {{$lang["profile_withdraw_maximum_withdraw_is"]}} {{$currency->symbol . " " . number_format($withdrawLimits->available_limit, 2, ",", ".")}} 
                            </span>
                            <span class="form-text text-xs">
                                Voce recebera <strong id="withdrawal-receivable"></strong> 
                            </span>
                        </div>
                    </div>     
          
                    <div class="form-group row withdraw_pix_key" >
                        <div class="col-lg-12">
                            <input type="text" name="pix_key" id="pix_key" class="form-control" placeholder="{{$lang["profile_withdraw_label_pix_key"]}}">
                        </div>
                    </div>


                    <div class="form-group row withdraw_pix_key" >
                        <div class="col-lg-12">
                            <select class="form-control select" name="pix_key_type" id="pix_key_type">
                                <option value=''>{{$lang["profile_withdraw_label_pix_key_type"]}}</option>
                                <option value='CPF'>{{$lang["profile_withdraw_label_pix_key_type_cpf"]}}</option>
                                <option value='CNPJ'>{{$lang["profile_withdraw_label_pix_key_type_cnpj"]}}</option>
                                <option value='PHONE'>{{$lang["profile_withdraw_label_pix_key_type_phone"]}}</option>
                                <option value='EMAIL'>{{$lang["profile_withdraw_label_pix_key_type_email"]}}</option>
                                <option value='EVP'>{{$lang["profile_withdraw_label_pix_key_type_evp"]}}</option>
                            </select>
                        </div>
                    </div> 

                </div>

                <div class="card-footer px-lg-5 py-lg-5 text-right">
                    <button type="button" class="btn btn-neutral btn-sm" data-dismiss="modal" id="btn-close-withdraw">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btn-send-withdraw" onclick="sendWithdraw();">
                        {{$lang["profile_withdraw_request_payout"]}}
                    </button>
                </div>

            </div>
        </div>
    </div>
    
    

@push('scripts')
<script>
        
    let timeoutWitdrawalCalc = null;
    $(document).ready(function () {

        $("#withdraw-amount").keyup(function () {
            if (timeoutWitdrawalCalc != null) {
                clearTimeout(timeoutWitdrawalCalc);
            }

            timeoutWitdrawalCalc = setTimeout(() => {
                calcWithdrawalReceive();
            }, 300);
        });
        
        $("#withdraw-amount").blur(function () {
            if (timeoutWitdrawalCalc != null) {
                clearTimeout(timeoutWitdrawalCalc);
            }

            timeoutWitdrawalCalc = setTimeout(() => {
                calcWithdrawalReceive();
            }, 300);
        });
    });

    function calcWithdrawalReceive() {
        let withdrawalValue = $("#withdraw-amount").val().replaceAll(".", "").replace(",", ".");
        if (withdrawalValue.length > 0) {
            withdrawalValue = parseFloat(withdrawalValue);
        } else {
            withdrawalValue = 0;
        }

        let willReceive = (withdrawalValue - (withdrawalValue * {{number_format($userTax->withdraw_charge, 2, ".", "")}} / 100) - {{number_format($userTax->withdraw_chargep, 2, ".", "")}});
        if (willReceive < 0) {
          willReceive = 0;
        }
        $("#withdrawal-receivable").html("R$ " + willReceive.toFixed(2).replace(","));
    } 

    function sendWithdraw() {
        let data = {
          _token: "{{csrf_token()}}",
          pix_key: $("#pix_key").val(),
          pix_key_type: $("#pix_key_type").val(),
          withdraw_amount: $("#withdraw-amount").val()
        };
      
        $("#btn-send-withdraw").prop("disabled", true);
        $.post("{{route('user.withdraw.send')}}", data, function (json) {
            try {
                if (json.success) {
                    $("#pix_key").val("");
                    $("#pix_key_type").val("");
                    $("#withdraw-amount").val("");
                    $("#btn-close-withdraw").trigger("click");
                    toastr.success(json.message);

                    setTimeout(() => {
                      location = "{{route('user.withdraw')}}";
                    }, 2000);
                } else {
                    toastr.error(json.message);
                }
            } catch (e) {
                toastr.error(e);
            }
        }, 'json').always(function () {
            $("#btn-send-withdraw").prop("disabled", false);
        });
    }

</script>
@endpush
        
@stop

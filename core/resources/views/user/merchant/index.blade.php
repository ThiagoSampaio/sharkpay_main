
@extends('userlayout')

@section('content')
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="content-wrapper">
    <div class="panel-page-stack">
      <div class="panel-page-hero">
        <span class="panel-page-hero__eyebrow"><i data-lucide="code-2" style="width: 14px; height: 14px;"></i> Integracao de websites</span>
        <h1 class="panel-page-hero__title">Cadastre lojas, acompanhe o desempenho por integracao e mantenha notificacoes sob controle.</h1>
        <p class="panel-page-hero__copy">Cada website cadastrado funciona como um ponto operacional para checkout e monitoramento. Use esta area para criar novas integracoes, copiar credenciais, revisar transacoes por origem e manter o fluxo de notificacoes consistente.</p>
        <div class="panel-page-hero__actions">
          <a data-toggle="modal" data-target="#add-merchant" href="" class="btn btn-neutral"><i class="fad fa-plus"></i> {{$lang["merchant_add_website"]}}</a>
          <a href="{{route('user.merchant-documentation')}}" class="btn btn-light"><i class="fad fa-file"></i> {{$lang["merchant_documentation"]}}</a>
        </div>
        <div class="panel-page-hero__meta">
          <div class="panel-page-meta-card">
            <span>Websites cadastrados</span>
            <strong>{{ count($merchant) }}</strong>
          </div>
          <div class="panel-page-meta-card">
            <span>Recebido</span>
            <strong>{{$currency->name}} {{number_format($received, 2, '.', '')}}</strong>
          </div>
          <div class="panel-page-meta-card">
            <span>Total monitorado</span>
            <strong>{{$currency->name}} {{number_format($total, 2, '.', '')}}</strong>
          </div>
        </div>
      </div>

      <div class="panel-note">
        <i data-lucide="workflow" style="width: 18px; height: 18px;"></i>
        <div>
          <strong>Fluxo recomendado.</strong>
          <p>Crie o website, configure email de notificacao se necessario, copie a merchant key e valide o comportamento de checkout antes de colocar a integracao em producao.</p>
        </div>
      </div>
    <div class="row">
      <div class="col-md-12">
        <div class="modal fade" id="add-merchant" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="mb-0 font-weight-bolder">{{$lang["merchant_add_new_website"]}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('submit.merchant')}}" method="post" id="modal-details">
                  @csrf
                    <div class="form-group row">
                      <div class="col-lg-12">
                        <input type="text" name="merchant_name" class="form-control" placeholder="{{$lang["merchant_merchant_name"]}}" required>
                      </div>
                    </div> 
                    <div class="form-group row">
                      <label class="col-form-label col-lg-12">{{$lang["merchant_send_notification_to"]}}</label>
                      <div class="col-lg-12">
                        <input type="email" name="email" class="form-control">
                        <span class="form-text text-xs">{{$lang["merchant_if_provided_this_email_address"]}}</span>
                      </div>
                    </div> 
                    <div class="text-right">
                    <button type="submit" class="btn btn-neutral btn-block" form="modal-details">{{$lang["merchant_create_merchant"]}}</button>
                    </div>         
                </form>
              </div>
            </div>
          </div>
        </div>         
      </div>
    </div>
    <div class="row">  
      <div class="col-md-8">
        <div class="row"> 
          @if(count($merchant)>0) 
            @foreach($merchant as $k=>$val)
              <div class="col-md-6">
                  <div class="card">
                    <!-- Card body -->
                    <div class="card-body">
                      <div class="row mb-2">
                        <div class="col-6">
                          <p class="text-sm text-dark mb-2"><a class="btn-icon-clipboard" data-clipboard-text="{{$val->merchant_key}}" title="Copy">{{$lang["merchant_copy_merchant_key"]}} <i class="fad fa-link text-xs"></i></a></p>
                        </div>  
                        <div class="col-6 text-right">
                          <a class="mr-0 text-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fad fa-chevron-circle-down"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-left">
                            <a class="dropdown-item" href="{{route('log.merchant', ['id' => $val->merchant_key])}}"><i class="fad fa-sync"></i>{{$lang["merchant_transactions"]}}</a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#edit{{$val->id}}" href="#"><i class="fad fa-pencil"></i>{{$lang["merchant_edit"]}}</a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#delete{{$val->id}}" href=""><i class="fad fa-trash"></i>{{$lang["merchant_delete"]}}</a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <h5 class="h4 mb-1 font-weight-bolder">{{$val->name}}</h5>
                          <p>{{$lang["merchant_reference"]}}: {{$val->ref_id}}</p>
                          <p>{{$lang["merchant_notify_email"]}}: @if($val->email==null) Nao configurado @else {{$val->email}} @endif</p>
                          <p class="text-sm mb-2">{{$lang["merchant_date"]}}: {{date("h:i:A j, M Y", strtotime($val->created_at))}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal fade" id="edit{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="mb-0 font-weight-bolder">{{$lang["merchant_edit_wbsite"]}}</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{route('update.merchant')}}" method="post" id="modal-detailx">
                        @csrf
                        <div class="form-group row">
                          <div class="col-lg-12">
                            <input type="text" name="name" class="form-control" placeholder="{{$lang["merchant_website_name"]}}" value="{{$val->name}}" required>
                            <input type="hidden" name="id" value="{{$val->id}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-lg-12">{{$lang["merchant_send_notification_to"]}}</label>
                          <div class="col-lg-12">
                            <input type="email" name="email" class="form-control" value="{{$val->email}}">
                            <span class="form-text text-xs">{{$lang["merchant_if_provided_this_email_address"]}}</span>
                          </div>
                        </div> 
                        <div class="text-right">
                          <button type="submit" class="btn btn-neutral btn-block" form="modal-detailx">{{$lang["merchant_update_website"]}}</button>
                        </div> 
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card bg-white border-0 mb-0">
                                <div class="card-header">
                                  <h3 class="mb-1 font-weight-bolder">{{$lang["merchant_delete_website"]}}</h3>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                  <span class="mb-0 text-xs">{{$lang["merchant_are_you_sure_you_want_to_delete"]}}</span>
                                </div>
                                <div class="card-body">
                                    <a  href="{{route('delete.merchant', ['id' => $val->id])}}" class="btn btn-danger btn-block">{{$lang["merchant_proceed"]}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="col-md-12 mb-5">
              <div class="text-center mt-8">
                <div class="mb-3">
                  <i class="bi bi-archive" style="font-size: 4rem; color: #000;"></i>

                </div>
                <h3 class="text-dark">{{$lang["merchant_no_website_found"]}}</h3>
                <p class="text-dark text-sm card-text">{{$lang["merchant_we_couldnt_find_any_website"]}}</p>
              </div>
            </div>
          @endif
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col text-center">
                <h4 class="mb-4 text-primary">
                {{$lang["merchant_statistics"]}}
                </h4>
                <span class="text-sm text-dark mb-0"><i class="fa fa-google-wallet"></i> {{$lang["merchant_received"]}}</span><br>
                <span class="text-xl text-dark mb-0">{{$currency->name}} {{number_format($received, 2, '.', '')}}</span><br>
                <hr>
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col">
                <div class="my-4">
                  <span class="surtitle">{{$lang["merchant_pending"]}}</span><br>
                  <span class="surtitle">{{$lang["merchant_abandoned"]}}</span><br>
                  <span class="surtitle ">{{$lang["merchant_total"]}}</span>
                </div>
              </div>
              <div class="col-auto">
                <div class="my-4">
                  <span class="surtitle ">{{$currency->name}} {{number_format($pending, 2, '.', '')}}</span><br>
                  <span class="surtitle ">{{$currency->name}} {{number_format($abadoned, 2, '.', '')}}</span><br>
                  <span class="surtitle ">{{$currency->name}} {{number_format($total, 2, '.', '')}}</span>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    </div>
@stop

@extends('userlayout')

@section('content')
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="content-wrapper">
    <div class="panel-page-stack">
      <div class="panel-page-hero">
        <span class="panel-page-hero__eyebrow"><i data-lucide="receipt-text" style="width: 14px; height: 14px;"></i> Catalogo de cobrancas</span>
        <h1 class="panel-page-hero__title">Consulte categorias, operadoras e itens disponiveis antes de publicar ou processar contas.</h1>
        <p class="panel-page-hero__copy">Esta tela ajuda a validar quais categorias de bill payment estao habilitadas, como cada item e identificado e qual valor padrao cada servico utiliza. Use isso como referencia operacional e de configuracao.</p>
        <div class="panel-page-hero__meta">
          <div class="panel-page-meta-card">
            <span>Itens listados</span>
            <strong>{{ count($log['data']) }}</strong>
          </div>
          <div class="panel-page-meta-card">
            <span>Uso recomendado</span>
            <strong>Consulta e validacao</strong>
          </div>
          <div class="panel-page-meta-card">
            <span>Leitura</span>
            <strong>Catalogo tecnico</strong>
          </div>
        </div>
      </div>

      <div class="panel-note">
        <i data-lucide="info" style="width: 18px; height: 18px;"></i>
        <div>
          <strong>Leitura rapida da grade.</strong>
          <p>Use o pais para origem do servico, tipo para identificar se o item pertence a fluxo de recarga e faturador para localizar a operadora ou parceiro responsavel.</p>
        </div>
      </div>

    <div class="card">
      <div class="card-header header-elements-inline">
        <h3 class="mb-0 font-weight-bolder">{{$lang["bill_categories"]}}</h3>
      </div>
      <div class="table-responsive py-4">
        <table class="table table-flush" id="datatable-buttons">
          <thead>
            <tr>
              <th>{{$lang["bill_s_n"]}}</th>
              <th>{{$lang["bill_biller_code"]}}</th>
              <th>{{$lang["bill_name"]}}</th>
              <th>{{$lang["bill_country"]}}</th>
              <th>Tipo</th>
              <th>Faturador</th>
              <th>{{$lang["bill_item_code"]}}</th>
              <th>{{$lang["bill_short_name"]}}</th>
              <th>{{$lang["bill_label_name"]}}</th>
              <th>{{$lang["bill_amount"]}}</th>
            </tr>
          </thead>
          <tbody>  
            @foreach($log['data'] as $k=>$v)
                
                <tr>
                    <td>{{++$k}}.</td>
                    <td>{{$v['biller_code']}}</td>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['country']}}</td>
                    <td>{{$v['is_airtime'] ? 'Recarga / airtime' : 'Conta / servico'}}</td>
                    <td>{{$v['biller_name']}}</td>
                    <td>{{$v['item_code']}}</td>
                    <td>{{$v['short_name']}}</td>
                    <td>{{$v['label_name']}}</td>
                    <td>{{$v['amount']}}</td>
                </tr>
                
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>

@stop
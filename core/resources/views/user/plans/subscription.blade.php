
@extends('userlayout')

@section('content')
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="content-wrapper">
    @php
      $renewalCount = count($sub->filter(function($item){ return $item->times > 0 && $item->status == 1; }));
    @endphp
    <div class="panel-page-stack">
      <div class="panel-page-hero">
        <span class="panel-page-hero__eyebrow"><i data-lucide="repeat" style="width: 14px; height: 14px;"></i> Assinaturas ativas</span>
        <h1 class="panel-page-hero__title">Monitore assinantes, renovacoes e expiracao dos seus planos recorrentes.</h1>
        <p class="panel-page-hero__copy">Esta grade mostra quem assinou, qual plano esta vinculado, quanto foi cobrado e quando o ciclo expira. Use a leitura recorrente para antecipar churn, revisar cobrancas e acompanhar a qualidade da base assinante.</p>
        <div class="panel-page-hero__meta">
          <div class="panel-page-meta-card">
            <span>Assinaturas listadas</span>
            <strong>{{ count($sub) }}</strong>
          </div>
          <div class="panel-page-meta-card">
            <span>Renovacao ativa</span>
            <strong>{{ $renewalCount }}</strong>
          </div>
          <div class="panel-page-meta-card">
            <span>Objetivo</span>
            <strong>Retencao e recorrencia</strong>
          </div>
        </div>
      </div>

    <div class="card">
      <div class="card-header header-elements-inline">
        <h3 class="mb-0 font-weight-bolder">{{$lang["plans_subscribers"]}}</h3>
      </div>
      <div class="table-responsive py-4">
        <table class="table table-flush" id="datatable-buttons">
          <thead>
            <tr>
              <th>{{$lang["plans_sn"]}}</th>
              <th>{{$lang["plans_name"]}}</th>
              <th>{{$lang["plans_amount"]}}</th>
              <th>{{$lang["plans_charge"]}}</th>
              <th>{{$lang["plans_plan"]}}</th>
              <th>{{$lang["plans_reference_id"]}}</th>
              <th>{{$lang["plans_expiring_date"]}}</th>
              <th>{{$lang["plans_renewal"]}}</th>
              <th>{{$lang["plans_created"]}}</th>
            </tr>
          </thead>
          <tbody>  
            @foreach($sub as $k=>$val)
              <tr>
                <td>{{++$k}}.</td>
                <td>{{$val->user['first_name']}} {{$val->user['last_name']}}</td>
                <td>{{$currency->symbol.number_format($val->amount, 2, '.', '')}}</td>
                <td>{{$currency->symbol.number_format($val->charge, 2, '.', '')}}</td>
                <td>{{$val->plan['name']}}</td>
                <td>#{{$val->ref_id}}</td>
                <td>{{date("Y/m/d h:i:A", strtotime($val->expiring_date))}}</td>
                <td>@if($val->times>0 && $val->status==1) {{$lang["plans_yes"]}} @else {{$lang["plans_no"]}} @endif</td>
                <td>{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>

@stop
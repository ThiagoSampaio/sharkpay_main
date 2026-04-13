@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-dark d-inline-block mb-0">Notificações</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('seller.settings') }}">Configurações</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Notificações</li>
                            </ol>
                        </nav>
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
                        <h3 class="mb-0">Preferências de Notificação</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('seller.settings.notifications.update') }}">
                            @csrf

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="email_new_order" name="email_new_order" {{ $settings['email_new_order'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="email_new_order">
                                    <strong>Email - Novo Pedido</strong>
                                    <p class="text-sm text-muted mb-0">Receba email quando houver um novo pedido</p>
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="email_new_customer" name="email_new_customer" {{ $settings['email_new_customer'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="email_new_customer">
                                    <strong>Email - Novo Cliente</strong>
                                    <p class="text-sm text-muted mb-0">Receba email quando houver um novo cliente</p>
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="email_refund_request" name="email_refund_request" {{ $settings['email_refund_request'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="email_refund_request">
                                    <strong>Email - Solicitação de Reembolso</strong>
                                    <p class="text-sm text-muted mb-0">Receba email quando houver solicitação de reembolso</p>
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="email_weekly_report" name="email_weekly_report" {{ $settings['email_weekly_report'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="email_weekly_report">
                                    <strong>Relatório Semanal</strong>
                                    <p class="text-sm text-muted mb-0">Receba relatório semanal de vendas</p>
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="sms_notifications" name="sms_notifications" {{ $settings['sms_notifications'] ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sms_notifications">
                                    <strong>Notificações SMS</strong>
                                    <p class="text-sm text-muted mb-0">Receba notificações via SMS</p>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Salvar Preferências</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

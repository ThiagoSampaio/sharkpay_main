@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-dark d-inline-block mb-0">Configurações</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Configurações</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Perfil</h5>
                                <p class="text-sm text-muted mb-0">Gerencie suas informações pessoais</p>
                            </div>
                        </div>
                        <a href="{{ route('seller.settings.profile') }}" class="btn btn-sm btn-primary mt-3">Acessar</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow mr-3">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Métodos de Pagamento</h5>
                                <p class="text-sm text-muted mb-0">Configure formas de recebimento</p>
                            </div>
                        </div>
                        <a href="{{ route('seller.settings.payment-methods') }}" class="btn btn-sm btn-primary mt-3">Acessar</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow mr-3">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Notificações</h5>
                                <p class="text-sm text-muted mb-0">Preferências de comunicação</p>
                            </div>
                        </div>
                        <a href="{{ route('seller.settings.notifications') }}" class="btn btn-sm btn-primary mt-3">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

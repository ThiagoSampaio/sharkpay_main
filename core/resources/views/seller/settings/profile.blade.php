@extends('userlayout')

@section('content')
<div class="container-fluid">
    <div class="header pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-dark d-inline-block mb-0">Perfil</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('seller.settings') }}">Configurações</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Perfil</li>
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
                        <h3 class="mb-0">Informações do Perfil</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Gerencie suas informações pessoais aqui.</p>
                        <!-- Adicionar formulário de perfil aqui -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="d-flex flex-column h-100">
                <!-- Logo -->
                <div class="p-4 text-center border-bottom border-light border-opacity-25">
                    <h3 class="text-white mb-0">
                        <i class="fas fa-shark me-2"></i>SharkPay
                    </h3>
                    <small class="text-white-50">Área do Vendedor</small>
                </div>

                <!-- Navigation -->
                <nav class="flex-grow-1 py-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>

                        <!-- Produtos -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/products*') ? 'active' : '' }}" href="{{ route('seller.products') }}">
                                <i class="fas fa-box"></i> Produtos
                            </a>
                        </li>

                        <!-- Analytics -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/analytics*') ? 'active' : '' }}" href="{{ route('seller.analytics') }}">
                                <i class="fas fa-chart-line"></i> Analytics
                            </a>
                        </li>

                        <!-- Relatórios -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/reports*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#reportsMenu">
                                <i class="fas fa-file-alt"></i> Relatórios
                                <i class="fas fa-chevron-down float-end mt-1"></i>
                            </a>
                            <div class="collapse {{ Request::is('seller/reports*') ? 'show' : '' }}" id="reportsMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('seller.reports.sales') }}">
                                            <i class="fas fa-dollar-sign"></i> Vendas
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('seller.reports.customers') }}">
                                            <i class="fas fa-users"></i> Clientes
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('seller.reports.products') }}">
                                            <i class="fas fa-chart-bar"></i> Produtos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Financeiro -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/balance') || Request::is('seller/withdrawals') || Request::is('seller/invoices') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#financeMenu">
                                <i class="fas fa-wallet"></i> Financeiro
                                <i class="fas fa-chevron-down float-end mt-1"></i>
                            </a>
                            <div class="collapse {{ Request::is('seller/balance') || Request::is('seller/withdrawals') || Request::is('seller/invoices') ? 'show' : '' }}" id="financeMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('seller.balance') }}">
                                            <i class="fas fa-coins"></i> Saldo
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('seller.withdrawals') }}">
                                            <i class="fas fa-money-bill-wave"></i> Saques
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('seller.invoices') }}">
                                            <i class="fas fa-receipt"></i> Notas Fiscais
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Comissões -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/commissions*') ? 'active' : '' }}" href="{{ route('seller.commissions') }}">
                                <i class="fas fa-handshake"></i> Comissões
                            </a>
                        </li>

                        <!-- Marketing -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/marketing*') ? 'active' : '' }}" href="{{ route('seller.marketing') }}">
                                <i class="fas fa-bullhorn"></i> Marketing
                            </a>
                        </li>

                        <!-- Configurações -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('seller/settings*') ? 'active' : '' }}" href="{{ route('seller.settings') }}">
                                <i class="fas fa-cog"></i> Configurações
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User Info -->
                <div class="p-3 border-top border-light border-opacity-25">
                    <div class="d-flex align-items-center text-white">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=0d6efd&color=fff"
                             class="avatar me-2" alt="Avatar">
                        <div class="flex-grow-1">
                            <div class="fw-bold small">{{ Auth::user()->name ?? 'Usuário' }}</div>
                            <div class="text-white-50 small">Vendedor</div>
                        </div>
                        <a href="{{ route('logout') }}" class="text-white" title="Sair"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-0 main-content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-top navbar-expand-lg">
                <div class="container-fluid">
                    <!-- Page Title / Breadcrumb -->
                    <div>
                        <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                        @hasSection('breadcrumb')
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 small">
                                    @yield('breadcrumb')
                                </ol>
                            </nav>
                        @endif
                    </div>

                    <!-- Right Menu -->
                    <div class="ms-auto d-flex align-items-center">
                        <!-- Notifications -->
                        <div class="dropdown me-3">
                            <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Notificações</h6></li>
                                <li><a class="dropdown-item" href="#">Nova venda realizada</a></li>
                                <li><a class="dropdown-item" href="#">Produto aprovado</a></li>
                                <li><a class="dropdown-item" href="#">Novo afiliado</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="#">Ver todas</a></li>
                            </ul>
                        </div>

                        <!-- User Menu -->
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=0d6efd&color=fff"
                                     class="avatar me-2" alt="Avatar">
                                {{ Auth::user()->name ?? 'Usuário' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('seller.settings.profile') }}">
                                    <i class="fas fa-user me-2"></i> Meu Perfil
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('seller.settings') }}">
                                    <i class="fas fa-cog me-2"></i> Configurações
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="p-4">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção!</strong> Corrija os erros abaixo:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('page-content')
            </div>
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection

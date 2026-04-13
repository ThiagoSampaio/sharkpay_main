@extends('layout')
@section('css')
<style>
    .home-hero {
        background: linear-gradient(135deg, #f7f8fc 0%, #eef4ff 55%, #fff8ef 100%);
        overflow: hidden;
        position: relative;
    }

    .home-hero::before,
    .home-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        opacity: 0.55;
        pointer-events: none;
    }

    .home-hero::before {
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, rgba(255, 167, 38, 0.18) 0%, rgba(255, 167, 38, 0) 72%);
        top: -140px;
        right: -120px;
    }

    .home-hero::after {
        width: 360px;
        height: 360px;
        background: radial-gradient(circle, rgba(49, 130, 246, 0.18) 0%, rgba(49, 130, 246, 0) 72%);
        left: -120px;
        bottom: -140px;
    }

    .home-hero-card,
    .home-feature-card,
    .home-panel,
    .home-stat-card,
    .home-cta-card,
    .home-review-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 18px 50px rgba(20, 32, 67, 0.08);
    }

    .home-hero-card {
        padding: 28px;
    }

    .home-stat-card,
    .home-feature-card,
    .home-review-card {
        height: 100%;
        padding: 28px;
    }

    .home-panel {
        padding: 42px;
    }

    .home-cta-card {
        padding: 40px;
        background: linear-gradient(135deg, #101828 0%, #1f2a44 100%);
        color: #fff;
    }

    .home-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(16, 24, 40, 0.06);
        color: #172033;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .home-display {
        font-size: 54px;
        line-height: 1.05;
        font-weight: 700;
        color: #141f34;
    }

    .home-copy,
    .home-review-copy,
    .home-panel-copy {
        color: #556070;
        font-size: 18px;
        line-height: 1.8;
    }

    .home-metric {
        padding: 18px 20px;
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid rgba(20, 32, 67, 0.06);
    }

    .home-metric-value {
        display: block;
        color: #141f34;
        font-size: 28px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 6px;
    }

    .home-metric-label,
    .home-stat-label {
        color: #667085;
        font-size: 14px;
    }

    .home-feature-icon,
    .home-stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #233876 0%, #0f9bd7 100%);
        color: #fff;
        font-size: 24px;
        margin-bottom: 18px;
    }

    .home-feature-card h5,
    .home-stat-card h5,
    .home-review-card h5,
    .home-panel h3,
    .home-cta-card h3 {
        color: #141f34;
        font-weight: 700;
    }

    .home-cta-card h3,
    .home-cta-card p,
    .home-cta-card .home-stat-label,
    .home-cta-card .home-metric-label {
        color: #fff;
    }

    .home-cta-card .home-metric {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.12);
    }

    .home-logo-strip {
        padding: 18px 22px;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 14px 40px rgba(20, 32, 67, 0.06);
    }

    .home-logo-strip img {
        max-height: 42px;
        width: auto !important;
        margin: 0 auto;
        filter: grayscale(1);
        opacity: 0.8;
    }

    .home-review-card {
        position: relative;
    }

    .home-review-mark {
        font-size: 58px;
        line-height: 1;
        color: rgba(35, 56, 118, 0.14);
        display: block;
        margin-bottom: 12px;
    }

    .home-avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        object-fit: cover;
    }

    .home-image-stack {
        position: relative;
        z-index: 1;
    }

    .home-image-stack img {
        width: 100%;
    }

    @media (max-width: 991px) {
        .home-display {
            font-size: 40px;
        }

        .home-panel,
        .home-cta-card {
            padding: 28px;
        }
    }
</style>
@stop
@section('content')
@php
    $serviceCount = isset($item) ? count($item) : 0;
    $brandCount = isset($brand) ? count($brand) : 0;
    $reviewCount = isset($review) ? count($review) : 0;
@endphp

<section class="home-hero effect-section p-90px-tb">
    <div class="container position-relative">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 m-15px-tb">
                <span class="home-kicker m-25px-b">
                    <i class="fal fa-bolt"></i>
                    {{$set->title}}
                </span>
                <h1 class="home-display m-25px-b">{{$ui->header_title}}</h1>
                <p class="home-copy m-35px-b">{{$ui->header_body}}</p>
                <div class="m-btn-wide d-flex flex-wrap align-items-center">
                    @if (Auth::guard('user')->check())
                        <a class="m-btn m-btn-radius m-btn-t-dark m-10px-r m-10px-b" href="{{route('user.dashboard')}}">
                            <span class="m-btn-inner-text">{{$lang['front_dashboard']}}</span>
                            <span class="m-btn-inner-icon arrow"></span>
                        </a>
                    @else
                        <a class="m-btn m-btn-radius m-btn-t-dark m-10px-r m-10px-b" href="{{route('login')}}">
                            <span class="m-btn-inner-text">{{$lang['front_sign_in']}}</span>
                            <span class="m-btn-inner-icon arrow"></span>
                        </a>
                        <a class="m-btn m-btn-radius m-btn-theme-light m-10px-r m-10px-b" href="{{route('register')}}">
                            <span class="m-btn-inner-text">{{$lang['front_get_started']}}</span>
                        </a>
                    @endif
                    <a class="m-btn m-btn-radius m-btn-border m-10px-b" href="{{route('about')}}">
                        <span class="m-btn-inner-text">{{$lang['front_more_abount_us']}}</span>
                    </a>
                </div>
                <div class="row m-25px-t">
                    <div class="col-sm-4 m-10px-tb">
                        <div class="home-metric">
                            <span class="home-metric-value">{{$serviceCount}}</span>
                            <span class="home-metric-label">solucoes ativas</span>
                        </div>
                    </div>
                    <div class="col-sm-4 m-10px-tb">
                        <div class="home-metric">
                            <span class="home-metric-value">{{$brandCount}}</span>
                            <span class="home-metric-label">integracoes e marcas</span>
                        </div>
                    </div>
                    <div class="col-sm-4 m-10px-tb">
                        <div class="home-metric">
                            <span class="home-metric-value">{{$reviewCount}}</span>
                            <span class="home-metric-label">avaliacoes publicas</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 m-15px-tb">
                <div class="home-hero-card">
                    <div class="home-image-stack m-25px-b">
                        <img src="{{url('/')}}/asset/images/{{$ui->s4_image}}" alt="{{$set->title}}">
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-10px-tb">
                            <div class="home-stat-card p-20px">
                                <div class="home-stat-icon">
                                    <i class="fal fa-link"></i>
                                </div>
                                <h5 class="m-10px-b">{{$lang['front_payment_pages']}}</h5>
                                <span class="home-stat-label">cobrancas rapidas, checkout claro e conversao direta.</span>
                            </div>
                        </div>
                        <div class="col-sm-6 m-10px-tb">
                            <div class="home-stat-card p-20px">
                                <div class="home-stat-icon">
                                    <i class="fal fa-store-alt"></i>
                                </div>
                                <h5 class="m-10px-b">{{$lang['front_storefront']}}</h5>
                                <span class="home-stat-label">catalogo, pedidos e recebimento no mesmo fluxo.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section p-40px-tb section-top-up-100">
    <div class="container">
        <div class="row justify-content-center m-40px-b">
            <div class="col-lg-8 text-center">
                <span class="home-kicker m-20px-b">{{$ui->s1_title}}</span>
                <h3 class="h1 m-15px-b">Operacao comercial concentrada em uma unica home</h3>
                <p class="home-panel-copy m-0px">A nova estrutura destaca captacao, cobranca, loja e relacionamento sem depender de varias paginas para explicar a proposta.</p>
            </div>
        </div>
        <div class="row">
            @foreach($item as $val)
                <div class="col-sm-6 col-lg-3 m-15px-tb">
                    <div class="home-feature-card">
                        <div class="home-feature-icon">
                            <i class="fal fa-check-circle"></i>
                        </div>
                        <h5 class="m-15px-b">{{$val->title}}</h5>
                        <p class="m-0px home-stat-label">{{$val->details}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if($brandCount > 0)
<section class="p-20px-tb m-30px-b">
    <div class="container">
        <div class="home-logo-strip">
            <div class="owl-carousel owl-loaded owl-drag" data-items="6" data-nav-dots="false" data-md-items="5" data-sm-items="4" data-xs-items="3" data-xx-items="2" data-space="24" data-autoplay="true">
                @foreach($brand as $brands)
                    <div class="p-10px">
                        <img src="{{url('/')}}/asset/brands/{{$brands->image}}" alt="{{$brands->name ?? $set->title}}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<section class="section effect-section p-70px-tb">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 m-15px-tb text-center">
                <img src="{{url('/')}}/asset/images/{{$ui->s3_image}}" alt="{{$ui->s3_title}}">
            </div>
            <div class="col-lg-5 m-15px-tb">
                <div class="home-panel">
                    <span class="home-kicker m-20px-b">{{$ui->s2_title}}</span>
                    <h3 class="h1 m-20px-b">{{$ui->s3_title}}</h3>
                    <p class="home-panel-copy m-25px-b">{{$ui->s3_body}}</p>
                    <div class="border-left-2 border-color-theme p-20px-l m-30px-b">
                        <h6 class="m-10px-b">{{$set->title}}</h6>
                        <p class="m-0px home-stat-label">{{$lang['front_stimulate_your_sales']}}</p>
                    </div>
                    <a class="m-btn m-btn-radius m-btn-theme-light" href="{{route('contact')}}">
                        <span class="m-btn-inner-text">Falar com a equipe</span>
                        <span class="m-btn-inner-icon arrow"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section effect-section p-70px-tb gray-bg">
    <div class="container">
        <div class="row justify-content-center m-40px-b">
            <div class="col-lg-8 text-center">
                <span class="home-kicker m-20px-b">estrutura de recebimento</span>
                <h3 class="h1 m-15px-b">{{$ui->s6_title}}</h3>
                <p class="home-panel-copy m-0px">{{$ui->s6_body}}</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-4 m-15px-tb">
                <div class="home-feature-card m-15px-b">
                    <div class="home-feature-icon"><i class="fal fa-random"></i></div>
                    <h5 class="m-10px-b">{{$lang['front_transfer_request_money']}}</h5>
                    <p class="m-0px home-stat-label">Transferencias e solicitacoes com menos friccao para operacoes recorrentes.</p>
                </div>
                <div class="home-feature-card m-15px-b">
                    <div class="home-feature-icon"><i class="fal fa-money-bill-wave-alt"></i></div>
                    <h5 class="m-10px-b">{{$lang['front_bill_payment']}}</h5>
                    <p class="m-0px home-stat-label">Receba com metodos variados e apresente cobranca com contexto claro.</p>
                </div>
            </div>
            <div class="col-lg-4 m-15px-tb text-center">
                <img src="{{url('/')}}/asset/images/{{$ui->s2_image}}" alt="{{$ui->s6_title}}">
            </div>
            <div class="col-lg-4 m-15px-tb">
                <div class="home-feature-card m-15px-b">
                    <div class="home-feature-icon"><i class="fal fa-envelope"></i></div>
                    <h5 class="m-10px-b">{{$lang['front_invoice_payment']}}</h5>
                    <p class="m-0px home-stat-label">Envio de cobrancas organizado, com leitura facil para o cliente final.</p>
                </div>
                <div class="home-feature-card m-15px-b">
                    <div class="home-feature-icon"><i class="fal fa-credit-card-front"></i></div>
                    <h5 class="m-10px-b">{{$lang['front_virtual_cards']}}</h5>
                    <p class="m-0px home-stat-label">Recursos complementares para ampliar autonomia operacional dentro da conta.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@if($reviewCount > 0)
<section class="section p-70px-tb">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5 m-15px-tb">
                <img src="{{url('/')}}/asset/images/{{$ui->s7_image}}" alt="{{$ui->s7_title}}">
            </div>
            <div class="col-lg-6 m-15px-tb">
                <span class="home-kicker m-20px-b">prova social</span>
                <h3 class="h1 m-20px-b">{{$ui->s7_title}}</h3>
                <div class="owl-carousel owl-nav-arrow-bottom" data-items="1" data-nav-arrow="true" data-nav-dots="false" data-md-items="1" data-sm-items="1" data-xs-items="1" data-xx-items="1" data-space="20" data-autoplay="true">
                    @foreach($review as $vreview)
                        <div class="home-review-card">
                            <span class="home-review-mark">“</span>
                            <p class="home-review-copy m-0px">{{$vreview->review}}</p>
                            <div class="media m-25px-t align-items-center">
                                <img class="home-avatar" src="{{url('/')}}/asset/review/{{$vreview->image_link}}" alt="{{$vreview->name}}">
                                <div class="media-body p-15px-l">
                                    <h6 class="m-0px">{{$vreview->name}}</h6>
                                    <span class="home-stat-label">{{$vreview->occupation}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="section p-70px-tb">
    <div class="container">
        <div class="home-cta-card text-center">
            <span class="home-kicker m-20px-b" style="background: rgba(255,255,255,0.12); color: #fff;">pronto para operar</span>
            <h3 class="h1 m-20px-b">{{$lang['front_join_millions_who_choose']}} {{$set->site_name}} {{$lang['front_worldwide']}}</h3>
            <p class="m-0px home-copy" style="color: rgba(255,255,255,0.82);">Abra a conta, organize sua cobranca e coloque a estrutura principal do negocio no ar com uma home mais direta e atual.</p>
            <div class="d-flex flex-wrap justify-content-center m-30px-t">
                <a class="m-btn m-btn-white m-btn-radius m-10px-r m-10px-b" href="{{route('register')}}">{{$lang['front_sign_up_for_free']}}</a>
                <a class="m-btn m-btn-radius m-btn-border white-color m-10px-b" href="{{route('contact')}}">Entrar em contato</a>
            </div>
        </div>
    </div>
</section>
@stop